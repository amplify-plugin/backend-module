<template>
    <div class="modal-content fm-modal-upload">
        <div class="modal-header">
            <h5 class="modal-title">{{ lang.modal.upload.title }}</h5>
            <button type="button" class="close" aria-label="Close" v-on:click="hideModal">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="fm-btn-wrapper" v-show="!progressBar">
                <button type="button" class="btn btn-secondary btn-block">
                    {{ lang.btn.uploadSelect }}
                </button>
                <input type="file" multiple name="myfile" v-on:change="selectFiles($event)">
            </div>
            <div class="fm-upload-list" v-if="countFiles">
                <div class="fm-upload-item"
                     v-for="(item, index) in newFiles"
                     v-bind:key="index">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="w-75 text-truncate">
                            <i class="far" v-bind:class="mimeToIcon(item.file.type)"/>
                            {{ item.file.name }}
                        </div>
                        <div class="text-right">
                            <span v-if="item.status === 'done'">&#10003;</span>
                            <span v-else-if="item.status === 'canceled'">&#10007;</span>
                            <span v-else>{{ bytesToHuman(item.file.size) }}</span>
                            <button type="button"
                                    class="close fm-upload-cancel"
                                    v-if="item.status === 'uploading'"
                                    v-bind:title="lang.btn.cancel"
                                    v-on:click="cancelFile(index)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="progress fm-file-progress" v-if="item.status === 'uploading'">
                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                             v-bind:aria-valuenow="item.progress"
                             aria-valuemin="0"
                             aria-valuemax="100"
                             v-bind:style="{width: item.progress + '%' }">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ lang.modal.upload.selected }}</strong>
                        {{ newFiles.length }}
                    </div>
                    <div class="text-right">
                        <strong>{{ lang.modal.upload.size }}</strong>
                        {{ allFilesSize }}
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ lang.modal.upload.ifExist }}</strong>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               id="uploadRadio1"
                               type="radio"
                               name="uploadOptions"
                               value="0"
                               checked
                               v-model="overwrite">
                        <label class="form-check-label" for="uploadRadio1">
                            {{ lang.modal.upload.skip }}
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               id="uploadRadio2"
                               type="radio"
                               name="uploadOptions"
                               value="1"
                               checked
                               v-model="overwrite">
                        <label class="form-check-label" for="uploadRadio2">
                            {{ lang.modal.upload.overwrite }}
                        </label>
                    </div>
                </div>
                <hr>
            </div>
            <div v-else><p>{{ lang.modal.upload.noSelected }}</p></div>
            <div class="fm-upload-info">
                <!-- Progress Bar -->
                <div class="progress" v-show="countFiles">
                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                         v-bind:aria-valuenow="progressBar"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         v-bind:style="{width: progressBar + '%' }">
                        {{ progressBar }}%
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn"
                    v-bind:class="[countFiles ? 'btn-info' : 'btn-light']"
                    v-bind:disabled="!countFiles"
                    v-on:click="uploadFiles">{{ lang.btn.submit }}
            </button>
            <button class="btn btn-light" v-on:click="hideModal()">{{ lang.btn.cancel }}</button>
        </div>
    </div>
</template>

<script>
import modal from '../mixins/modal';
import translate from '../../../mixins/translate';
import helper from '../../../mixins/helper';
import POST from '../../../http/post';

// chunk size - 5 MB
const CHUNK_SIZE = 5 * 1024 * 1024;

export default {
  name: 'Upload',
  mixins: [modal, translate, helper],
  data() {
    return {
      // selected files - { file, progress, status, uploadId, controller }
      newFiles: [],

      // overwrite if exists
      overwrite: 0,
    };
  },
  /**
   * Abort all active uploads when the modal is closed
   */
  beforeDestroy() {
    for (let i = 0; i < this.newFiles.length; i += 1) {
      if (this.newFiles[i].status === 'uploading') {
        this.cancelFile(i);
      }
    }
  },
  computed: {

    /**
     * Progress bar value - %
     * @returns {number}
     */
    progressBar() {
      return this.$store.state.fm.messages.actionProgress;
    },

    /**
     * Count of files selected for upload
     * @returns {number}
     */
    countFiles() {
      return this.newFiles.length;
    },

    /**
     * Calculate the size of all files
     * @returns {*|string}
     */
    allFilesSize() {
      let size = 0;

      for (let i = 0; i < this.newFiles.length; i += 1) {
        size += this.newFiles[i].file.size;
      }

      return this.bytesToHuman(size);
    },

  },
  methods: {
    /**
     * Select file or files
     * @param event
     */
    selectFiles(event) {
      // files selected?
      if (event.target.files.length === 0) {
        this.newFiles = [];
      } else {
        // wrap each file with its own upload state
        this.newFiles = Array.from(event.target.files).map((file) => ({
          file,
          progress: 0,
          // ready | uploading | done | canceled | error
          status: 'ready',
          uploadId: `${Date.now().toString(36)}-${Math.random().toString(36).slice(2)}`,
          controller: null,
        }));
      }
    },

    /**
     * Update the global progress bar
     */
    updateGlobalProgress() {
      let totalBytes = 0;
      let uploadedBytes = 0;

      for (let i = 0; i < this.newFiles.length; i += 1) {
        // skip canceled files
        if (this.newFiles[i].status !== 'canceled') {
          totalBytes += this.newFiles[i].file.size;
          uploadedBytes += (this.newFiles[i].progress / 100) * this.newFiles[i].file.size;
        }
      }

      const progress = totalBytes ? Math.round((uploadedBytes * 100) / totalBytes) : 0;

      this.$store.commit('messages/setProgress', progress);
    },

    /**
     * Upload a single file in chunks
     * @param index
     * @returns {Promise}
     */
    uploadSingleFile(index) {
      const item = this.newFiles[index];
      const file = item.file;
      // total count of chunks for the file
      const totalChunks = Math.max(1, Math.ceil(file.size / CHUNK_SIZE));
      // abort controller for this file
      item.controller = new AbortController();

      item.status = 'uploading';

      const config = {
        signal: item.controller.signal,
      };

      const uploadNextChunk = (chunkIndex) => {
        // the file was canceled
        if (item.status !== 'uploading') {
          return Promise.resolve(null);
        }

        const start = chunkIndex * CHUNK_SIZE;
        const end = Math.min(start + CHUNK_SIZE, file.size);

        const data = new FormData();
        data.append('disk', this.$store.getters['fm/selectedDisk']);
        data.append('path', this.$store.getters['fm/selectedDirectory'] || '');
        data.append('upload_id', item.uploadId);
        data.append('chunk_index', chunkIndex);
        data.append('chunk', file.slice(start, end));

        return POST.uploadChunk(data, config).then(() => {
          item.progress = Math.round((end * 100) / file.size);
          this.updateGlobalProgress();

          if (chunkIndex + 1 < totalChunks) {
            // upload the next chunk
            return uploadNextChunk(chunkIndex + 1);
          }

          // all chunks uploaded - assemble the file, server side
          return POST.uploadChunkFinish({
            disk: this.$store.getters['fm/selectedDisk'],
            path: this.$store.getters['fm/selectedDirectory'] || '',
            upload_id: item.uploadId,
            name: file.name,
            total_chunks: totalChunks,
            overwrite: this.overwrite,
          });
        });
      };

      return uploadNextChunk(0).then((response) => {
        if (item.status === 'uploading') {
          if (response && response.data.result.status === 'success') {
            item.status = 'done';
          } else {
            item.status = 'error';
          }
        }

        return response;
      }).catch((error) => {
        if (item.status !== 'canceled') {
          item.status = 'error';
        }

        throw error;
      });
    },

    /**
     * Cancel the upload of a single file
     * @param index
     */
    cancelFile(index) {
      const item = this.newFiles[index];

      if (item.status !== 'uploading' || !item.controller) {
        return;
      }

      item.status = 'canceled';

      // abort the current chunk request
      item.controller.abort();

      // remove stored chunks, server side
      POST.uploadAbort(item.uploadId);

      this.updateGlobalProgress();
    },

    /**
     * Upload new files - each file separately
     */
    uploadFiles() {
      // if files exists
      if (!this.countFiles) {
        return;
      }

      // upload files one by one, each in chunks
      const uploadNext = (index) => {
        if (index >= this.newFiles.length) {
          return Promise.resolve();
        }

        // skip canceled files
        if (this.newFiles[index].status === 'canceled') {
          return uploadNext(index + 1);
        }

        return this.uploadSingleFile(index)
          .catch(() => {})
          .then(() => uploadNext(index + 1));
      };

      uploadNext(0).then(() => {
        // clear progress
        this.$store.commit('messages/clearProgress');

        const finished = this.newFiles.filter((item) => item.status === 'done').length;

        // if at least one file uploaded - refresh content
        if (finished) {
          this.$store.dispatch('fm/refreshManagers');
        }

        // if all files uploaded successfully - close modal window
        if (finished === this.newFiles.length) {
          this.hideModal();
        }
      });
    },
  },
};
</script>

<style lang="scss">
    .fm-modal-upload {

        .fm-btn-wrapper {
            position: relative;
            overflow: hidden;
            padding-bottom: 6px;
            margin-bottom: 0.6rem;
        }

        .fm-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }

        .fm-upload-list .far {
            padding-right: 0.5rem;
        }

        .fm-upload-list .fm-upload-cancel {
            display: inline-block;
            margin-left: 0.5rem;
            font-size: 1rem;
        }

        .fm-upload-list .fm-file-progress {
            height: 4px;
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .fm-upload-list .form-check-inline {
            margin-right: 0;
        }

        .fm-upload-info > .progress {
            margin-bottom: 1rem;
        }
    }
</style>
