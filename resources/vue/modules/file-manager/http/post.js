import HTTP from './axios';

export default {
  /**
   * Create new file
   * @param disk
   * @param path
   * @param name
   * @returns {AxiosPromise<any>}
   */
  createFile(disk, path, name) {
    return HTTP.post('create-file', { disk, path, name });
  },

  /**
   * Update file
   * @param formData
   * @returns {*}
   */
  updateFile(formData) {
    return HTTP.post('update-file', formData);
  },

  /**
   * Create new directory
   * @param data
   * @returns {*}
   */
  createDirectory(data) {
    return HTTP.post('create-directory', data);
  },

  /**
   * Upload file
   * @param data
   * @param config
   * @returns {AxiosPromise<any>}
   */
  upload(data, config) {
    return HTTP.post('upload', data, config);
  },

  /**
   * Upload a single file chunk
   * @param data
   * @param config
   * @returns {AxiosPromise<any>}
   */
  uploadChunk(data, config) {
    return HTTP.post('upload-chunk', data, config);
  },

  /**
   * Finalize a chunked upload - assemble chunks and store to the disk
   * @param data
   * @returns {AxiosPromise<any>}
   */
  uploadChunkFinish(data) {
    return HTTP.post('upload-chunk-finish', data);
  },

  /**
   * Abort a chunked upload - remove stored chunks, server side
   * @param uploadId
   * @returns {AxiosPromise<any>}
   */
  uploadAbort(uploadId) {
    return HTTP.post('upload-abort', { upload_id: uploadId });
  },

  /**
   * Delete selected items
   * @param data
   * @returns {*}
   */
  delete(data) {
    return HTTP.post('delete', data);
  },

  /**
   * Rename file or folder
   * @param data
   * @returns {*}
   */
  rename(data) {
    return HTTP.post('rename', data);
  },

  /**
   * Copy / Cut files and folders
   * @param data
   * @returns {*}
   */
  paste(data) {
    return HTTP.post('paste', data);
  },

  /**
   * Zip
   * @param data
   * @returns {*}
   */
  zip(data) {
    return HTTP.post('zip', data);
  },

  /**
   * Unzip
   * @returns {*}
   * @param data
   */
  unzip(data) {
    return HTTP.post('unzip', data);
  },
};
