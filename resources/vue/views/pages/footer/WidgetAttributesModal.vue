<template>
  <div>
      <div class="modal fade" id="widget-attributes-modal" tabIndex="0" role="dialog"
           aria-labelledby="widget-attributes-modal-dialog-label"
           data-backdrop="static" data-keyboard="false"
           aria-modal="true">
          <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                          Set attributes for <strong> {{ makeTitleCase(widget.name) }} </strong>
                      </h5>
                      <button type="button" class="close" data-dismiss="modal"
                              @click="modalShade = ''; resetWidgetData()"
                              aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="modal-body bg-light">
                      <!-- Default box -->
                      <div class="card" style="margin-bottom: 0!important;">
                          <div class="card-body">
                              <div v-show="showFileManagerIFrame">
                                  <div class="col-12 mt-2">
                                      <div class="card">
                                          <div class="card-body">
                                              <file-manager ref="fileManager"></file-manager>
                                          </div>
                                          <div class="card-footer text-right">
                                              <label
                                                  class="btn btn-danger btn-sm btn-file py-2 mb-0 cursor-pointer"
                                                  title="close file manager"
                                                  for="elfinder-iframe-close-button">
                                                  <i class="la la-times-circle"></i>{{ titles.close_file_manager }}
                                                  <input id="elfinder-iframe-close-button" type="text"
                                                         class="form-control d-none file_design"
                                                         title="close file manager"
                                                         @click="showFileManagerIFrame = !showFileManagerIFrame"
                                                  >
                                              </label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div v-if="!showFileManagerIFrame">
                                  <div v-if="widget['@inside']" class="form-row">
                                      <div class="form-group col-12">
                                          <label>Inside text of the tag</label>
                                          <input type="text" v-model="widget['@inside']" class="form-control">
                                      </div>
                                  </div>

                                  <div v-if="showAttributes">
                                      <label class="font-weight-bold">Attributes:</label>
                                      <div class="form-group"
                                           v-for="(attribute, indexOfAttributes) in widget['@attributes']"
                                           :key="indexOfAttributes">
                                          <label :for="attribute.name"
                                                 v-if="attribute.type !== 'banner-code' || (attribute.type === 'banner-code' && $parent.showBannerCode)">
                                              {{ makeTitleCase(attribute.name) }}
                                          </label>

                                          <div v-if="attribute.type === 'boolean' || attribute.type === 'bool'">
                                              <div class="form-check form-check-inline">
                                                  <input class="form-check-input" :id="attribute.name + 'true'"
                                                         type="radio" value="true"
                                                         :name="attribute.name"
                                                         v-model="attribute.value">
                                                  <label class="form-check-label"
                                                         :for="attribute.name + 'true'">Yes</label>
                                              </div>
                                              <div class="form-check form-check-inline">
                                                  <input class="form-check-input" :id="attribute.name + 'false'"
                                                         type="radio" value="false"
                                                         :name="attribute.name"
                                                         v-model="attribute.value">
                                                  <label class="form-check-label"
                                                         :for="attribute.name + 'false'">No</label>
                                              </div>
                                          </div>

                                          <div v-if="attribute.type === 'text'">
                                              <input type="text" v-model="attribute.value" class="form-control">
                                          </div>

                                          <div v-if="attribute.type === 'textarea'">
                                              <textarea v-model="attribute.value" class="form-control" rows="3"></textarea>
                                          </div>

                                          <div v-if="attribute.type === 'range'">
                                              <input type="range" v-model="attribute.value"
                                                     :min="attribute.min ?? 0"
                                                     :max="attribute.max ?? 0"
                                                     :step="attribute.step ?? 'any'"
                                                     class="form-control custom-range">
                                          </div>

                                          <div v-if="attribute.type === 'number'">
                                              <input type="number" v-model="attribute.value" class="form-control">
                                          </div>

                                          <div v-if="attribute.type === 'url'">
                                              <input type="url" v-model="attribute.value" class="form-control">
                                          </div>

                                          <div v-if="attribute.type === 'email'">
                                              <input type="email" v-model="attribute.value" class="form-control">
                                          </div>

                                          <div v-if="attribute.type === 'color'">
                                              <input type="color" v-model="attribute.value" class="form-control">
                                          </div>

                                          <div v-if="attribute.type === 'select'">
                                              <select class="form-control custom-select" v-model="attribute.value">
                                                  <option value="">Select an option</option>
                                                  <option v-for="(option, value) in attribute.options" :key="value"
                                                          :selected="value === attribute.value">
                                                      {{ option }}
                                                  </option>
                                              </select>
                                          </div>

                                          <div class="d-block" v-if="attribute.type === 'merchandises-dropdown'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="merchandiseOptions"
                                                  placeholder="Select a merchandising zone"
                                                  label="name"
                                                  track-by="name">
                                              </multiselect>
                                          </div>

                                          <div class="d-block" v-if="attribute.type === 'permission-dropdown'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="permissionOptions"
                                                  placeholder="Select a permission"
                                                  label="name"
                                                  track-by="name">
                                              </multiselect>
                                          </div>

                                          <div class="d-block" v-if="attribute.type === 'form-dropdown'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="formOptions"
                                                  placeholder="Select a form"
                                                  label="name"
                                                  track-by="code">
                                              </multiselect>
                                          </div>

                                          <div class="d-block"
                                               v-if="attribute.type === 'banner-zone'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="bannerZoneOptions"
                                                  placeholder="Select a banner zone code"
                                                  label="name"
                                                  track-by="code"
                                                  @input="onChangeBannerZoneDropdown($event)">
                                              </multiselect>
                                          </div>

                                          <div class="d-block"
                                               v-if="attribute.type === 'banner-code' && $parent.showBannerCode">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="bannerItemCodeOptions"
                                                  placeholder="Select a banner item code"
                                                  label="code"
                                                  track-by="code">
                                              </multiselect>
                                          </div>

                                          <div class="d-block"
                                               v-if="attribute.type === 'content-dropdown'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="contentOptions"
                                                  placeholder="Select a content"
                                                  label="name"
                                                  track-by="name">
                                              </multiselect>
                                          </div>

                                          <div class="d-block" v-if="attribute.type === 'menugroup-dropdown'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="menuGroupOptions"
                                                  placeholder="Select a menu group"
                                                  label="name"
                                                  track-by="name">
                                              </multiselect>
                                          </div>

                                          <div class="d-block" v-if="attribute.type === 'page-dropdown'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="pageOptions"
                                                  placeholder="Select a page"
                                                  label="name"
                                                  group-values="pages"
                                                  group-label="name"
                                                  track-by="id">
                                              </multiselect>
                                          </div>

                                          <div class="d-block" v-if="attribute.type === 'category-dropdown'">
                                              <multiselect
                                                  v-model="attribute.value"
                                                  :options="categoryOptions"
                                                  :searchable="true"
                                                  :multiple="true"
                                                  placeholder="Select Category"
                                                  label="value"
                                                  track-by="id">
                                              >
                                              </multiselect>
                                          </div>

                                          <div class="d-block"
                                               v-if="attribute.type === 'array' && (typeof attribute.array_format == 'undefined')">
                                              <div class="row" v-for="(item, indexOfvalue) in attribute.value"
                                                   :key="indexOfvalue">
                                                  <div class="col">
                                                      <label>{{
                                                              `${makeTitleCase(attribute.name)}-${indexOfvalue + 1}`
                                                          }}</label>
                                                      <input type="text" class="form-control"
                                                             v-model="attribute.value[indexOfvalue]">
                                                  </div>
                                                  <div class="col-auto" v-if="attribute.value.length > 1">
                                                      <button class="btn btn-danger" style="margin-top: 2.5rem"
                                                              @click="attribute.value.splice(indexOfvalue ,1)">
                                                          <i class="la la-remove"></i>
                                                      </button>
                                                  </div>
                                              </div>
                                              <button class="btn btn-success float-right"
                                                      @click="addArrayItem(attribute.value)">
                                                  <i class="la la-plus"></i>
                                              </button>
                                          </div>

                                          <div class="d-block"
                                               v-if="attribute.type === 'array' && (typeof attribute.array_format != 'undefined')">
                                              <div class="d-flex bg-secondary my-2 rounded border"
                                                   v-for="(item, indexOfvalue) in attribute.value"
                                                   :key="indexOfvalue">
                                                  <div class="mt-2 mb-3 col-md"
                                                       v-for="(format, indexOfFormat) in attribute.array_format"
                                                       :key="indexOfFormat">
                                                      <label>{{ makeTitleCase(format.name) }}</label>
                                                      <input :type="format.type" class="form-control"
                                                             v-model="item[format.name]"
                                                             v-if="format.type !== 'select'">

                                                      <select class="form-control custom-select"
                                                              v-model="item[format.name]" v-else>
                                                          <option :key="indexOfOption"
                                                                  v-for="(option, indexOfOption) in format.options"
                                                                  :value="option.value"
                                                                  :selected="format.value === option.value">
                                                              {{ option.name }}
                                                          </option>

                                                      </select>

                                                  </div>
                                                  <div class="col-auto" v-if="attribute.value.length > 1">
                                                      <button class="btn btn-danger" style="margin-top: 2rem"
                                                              @click="attribute.value.splice(indexOfvalue ,1)">
                                                          <i class="la la-remove"></i>
                                                      </button>
                                                  </div>
                                              </div>
                                              <button class="btn btn-success float-right"
                                                      @click="addArrayItem(attribute.value, attribute.array_format)">
                                                  <i class="la la-plus"></i>
                                              </button>
                                          </div>

                                          <div class="d-block" v-if="attribute.type === 'image'">
                                              <div class="d-flex">
                                                  <div class="w-75">
                                                      <input placeholder="upload path" type="text"
                                                             class="form-control"
                                                             v-model="attribute.value">
                                                  </div>
                                                  <div class="w-25 text-center px-3 m-auto">
                                                      <div class="btn-group">
                                                          <label
                                                              class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer"
                                                              title="select file"
                                                              for="main-image-browse">
                                                              <i class="la la-hand-pointer"></i>{{
                                                                  titles.choose_file
                                                              }}
                                                              <input id="main-image-browse" type="text"
                                                                     class="form-control d-none file_design"
                                                                     title="select file"
                                                                     @click="showFileManagerIFrame = !showFileManagerIFrame; processImagesByType(indexOfAttributes); canMultiple = false;"
                                                              >
                                                          </label>
                                                          <button class="btn btn-danger btn-sm" data-handle="remove"
                                                                  @click="deleteImage(indexOfAttributes)"
                                                                  type="button">
                                                              <i class="la la-trash"></i>
                                                          </button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <small
                                              v-show="typeof attribute.hint != 'undefined'"
                                              class="text-muted font-italic">
                                              <span class="font-weight-bold">Hint:</span> {{ attribute.hint }}
                                          </small>
                                      </div>
                                  </div>

                                  <div v-if="showNestedItems">
                                      <h5>
                                          <span class="text">Nested Tags</span>
                                      </h5>

                                      <div v-for="(nestedItem, indexOfNestedItems) in widget['@nestedItems']"
                                           class="mb-3" :key="indexOfNestedItems">
                                          <fieldset class="form-group border p-3">
                                              <legend class="w-auto px-2" style="font-size: 1rem!important;">
                                                  <strong>
                                                      {{ makeTitleCase(nestedItem.name) }}
                                                  </strong>
                                              </legend>

                                              <div v-if="nestedItem['@inside']" class="form-row">
                                                  <div class="form-group col-12">
                                                      <label>
                                                          <strong>
                                                              Inside text of the tag
                                                          </strong>
                                                      </label>
                                                      <input type="text"
                                                             v-model="nestedItem['@inside']"
                                                             class="form-control">
                                                  </div>
                                              </div>

                                              <div v-if="nestedItem['@attributes'].length > 0">
                                                  <label>
                                                      <strong>
                                                          Attributes :
                                                      </strong>
                                                  </label>
                                                  <div class="form-row"
                                                       v-for="(attribute, indexOfAtt) in nestedItem['@attributes']"
                                                       :key="indexOfAtt">
                                                      <div class="form-group col-12"
                                                           v-if="attribute.type === 'boolean'">
                                                          <label>
                                                              <strong>
                                                                  {{ makeTitleCase(attribute.name) }}
                                                              </strong>
                                                          </label>
                                                          <div>
                                                              <div class="form-check form-check-inline">
                                                                  <input class="form-check-input" type="radio"
                                                                         value="true"
                                                                         :name="attribute.name"
                                                                         v-model="attribute.value">
                                                                  <label class="form-check-label">Yes</label>
                                                              </div>
                                                              <div class="form-check form-check-inline">
                                                                  <input class="form-check-input" type="radio"
                                                                         value="false"
                                                                         :name="attribute.name"
                                                                         v-model="attribute.value">
                                                                  <label class="form-check-label">No</label>
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="form-group col-12" v-if="attribute.type === 'text'">
                                                          <label>
                                                              <strong>
                                                                  {{ makeTitleCase(attribute.name) }}
                                                              </strong>
                                                          </label>
                                                          <input type="text"
                                                                 v-model="attribute.value"
                                                                 class="form-control">
                                                      </div>
                                                  </div>
                                              </div>
                                          </fieldset>
                                      </div>
                                  </div>

                                  <div v-if="!widget['@inside'] && !showAttributes && !showNestedItems"
                                       class="form-row">
                                      <div class="col-12 text-center">
                                          No attributes / nested items found
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal"
                              @click="modalShade = ''; resetWidgetData()"
                              aria-label="Close" id="cancelWidgetAttributesModalBtn">Cancel
                      </button>

                      <button type="button" class="btn btn-primary" @click="saveData()"
                              id="saveButton">Generate Widget
                      </button>
                  </div>
              </div>
          </div>
      </div>
      <div v-html="modalShade"></div>
  </div>
</template>
<script>
import allDisksMixin from '../../../allDisks.mixin';
import _ from 'lodash';

export default {
  name: "WidgetAttributesModal",
  mixins: [allDisksMixin],
  props: [],
  data() {
      return {
          loadedModal: 'Loading modal...',
          modalShade: '',
          modalBody: 'Loading...',
          validationErrors: "",
          widget: {
              name: "",
              code: {
                  "name": null,
                  "@inside": null,
                  "@attributes": [],
                  "@nestedItems": [],
              }
          },
          backupWidget: {},
          showAttributes: false,
          showNestedItems: false,
          titles: {
              upload_file: ' Upload File',
              choose_file: ' Choose File',
              close_file_manager: ' Close File Manager',
          },
          menu: {
              title: '',
              url: '',
              children: [
                  {
                      'title': '',
                      'url': '',
                  }
              ],
          },
          selectedFiles: [],
          showFileManagerIFrame: false,
          canMultiple: false,
          indexOfAttributes: 0,
          selectedPage: '',
          showPageSelect: false,
          menuGroupOptions: [],
          merchandiseOptions: [],
          bannerZoneOptions: [],
          bannerItemCodeOptions: [],
          formOptions: [],
          pageOptions: [],
          contentOptions: [],
          categoryOptions: []
      }
  },

  mounted() {
      this.backupWidget = _.cloneDeep(this.widget);

      this.configureWidgetData('menu_group_lists', 'menuGroupOptions');

      this.configureWidgetData('merchandising_zones', 'merchandiseOptions');

      this.configureWidgetData('banner_zones', 'bannerZoneOptions');

      this.configureWidgetData('banner_item_codes', 'bannerItemCodeOptions');

      this.configureWidgetData('content_lists', 'contentOptions');

      this.configureWidgetData('category_lists', 'categoryOptions');

      this.configureWidgetData('form_lists', 'formOptions');

      this.configureWidgetData('page_lists', 'pageOptions');

      this.configureWidgetData('permissions', 'permissionOptions');
  },

  methods: {
      getModal() {
          this.widget = this.$parent.activeWidget;
          this.showAttributes = this.widget['@attributes'].length > 0;
          this.showNestedItems = (this.widget['@nestedItems'] !== null) ? this.widget['@nestedItems'].length > 0 : false;

          setTimeout(() => {
              let modalShade = document.querySelector(".modal-backdrop.fade.show");
              modalShade ? modalShade.remove() : null;
              this.modalShade = modalShade.outerHTML
              this.modalBody = document.querySelector("#widget-attributes-modal .modal-body").innerHTML
          }, 100);
      },

      saveData() {

          axios.post(`/admin/page/fetch/convert-object-to-code`, {
              'page_type': this.$parent.page.page_type,
              'code': JSON.stringify(this.widget)
          }).then(response => {
              new Noty({
                  type: response.data.type,
                  text: response.data.message,
              }).show();

              this.$parent.code = response.data.code;
              document.querySelector("#cancelWidgetAttributesModalBtn").click();
          }).catch((err) => {

              let error = err.response.data;

              new Noty({
                  type: error.type,
                  text: error.message,
              }).show();
              document.querySelector("#cancelWidgetAttributesModalBtn").click();
          });
      },

      makeTitleCase(title) {
          if (!title) return "";

          title = title.split('-')
              .map(w => w[0].toUpperCase() + w.substring(1).toLowerCase())
              .join(' ');

          return title.replace('X ', '');
      },

      resetWidgetData() {
          this.widget = _.cloneDeep(this.backupWidget);
          this.$parent.activeWidget = null;
          this.$parent.activeWidgetIndex = undefined;
      },

      addArrayItem(attribute, format = []) {
          let newfield;
          if (format.length) {
              newfield = {};
              format.forEach(item => newfield[item.name] = "");
          }
          attribute.push(newfield);
      },

      // File Manager methods
      removeSelectedFiles(index, length = 1) {
          let path = this.selectedFiles.splice(index, length);
          let noty = {
              type: 'success',
              text: `File (${path}) removed!`,
          };
          new Noty(noty).show()
      },

      browseMainImage(event) {
          event.preventDefault();
      },

      onChangeBannerZoneDropdown(event) {

          if (!event)
              return;

          if (event.fetch_data_from_easyask == 1) {
              this.$parent.showBannerCode = false;
              this.widget['@attributes'][1].value = null;
          } else {
              this.$parent.showBannerCode = true;
          }

      },

      processImagesByType(indexOfAttributes = 0) {
          this.indexOfAttributes = indexOfAttributes;
          this.selectedFiles = this.widget['@attributes'][indexOfAttributes].value;
      },

      getFileAddedMessage() {
          let noty = {
              type: "success",
              text: "File path added!",
          };

          new Noty(noty).show();
      },

      deleteImage(indexOfAttributes = 0) {
          this.$swal({
              title: 'Remove this Image?',
              //icon              : 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ff6b81',
              cancelButtonColor: '#399E7F',
              confirmButtonText: 'Remove'

          }).then((result) => {
              if (result.isConfirmed) {
                  this.widget['@attributes'][indexOfAttributes].value = '';
              }
          });
      },

      getFileExtension(file) {
          const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
          const extension = file.match(regexp);
          return extension && extension[1];
      },

      async configureWidgetData(field, target) {

          await axios.get(`/admin/page/get-widget-data/` + field, {
              headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json'
              }
          }).then(response => this[target] = response.data);
      },

  },

  watch: {
      "$store.state.fm.left.selected.files": {
          handler(files) {
              if (files.length) {
                  const self = this;

                  if (self.canMultiple) {
                      let filesPath = files.filter(file => {
                          return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                      });

                      if (filesPath) {
                          self.$parent.selectedFiles = filesPath.map(filePath => {
                              return self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                          })
                      }
                  } else {
                      let filePath = files.find(file => {
                          return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                      });

                      if (filePath) {
                          self.$parent.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                      }
                  }
                  self.widget['@attributes'][self.indexOfAttributes].value = self.$parent.selectedFiles;
                  self.getFileAddedMessage();
              }
          }
      }
  },
}
</script>

<style scoped>
h5 {
  text-align: center;
  position: relative;
  background-color: #fff;
}

h5 .border {
  border-bottom: 3px solid #999;
  position: absolute;
  width: 100%;
  left: 0;
  top: 50%;
  margin-top: -1px;
  z-index: 1;
}

h5 .text {
  background-color: #fff;
  position: relative;
  z-index: 2;
  padding: 10px;
  display: inline-block;
}
</style>
