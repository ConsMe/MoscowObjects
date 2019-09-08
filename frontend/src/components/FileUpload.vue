<template>
  <div class="border file-upload row pt-2 position-relative ml-0 mr-0">
    <template v-if="type === 'images'">
      <div class="col col-auto mb-2" v-for="(file, id) in allFiles" :key="id">
        <div class="row justify-content-center">
            <div class="col col-auto">
            <span class="position-relative d-inline-block image-wrapper">
                <img :src="file.src" class="img-thumbnail" />
                <div class="image-bg bg-primary text-white">
                    <p class="mt-5 pl-2 pr-2 text-white text-break">
                        {{ file.original_filename ? file.original_filename : file.filename }}
                    </p>
                </div>
                <button
                    class="btn remove-image btn-outline-danger btn-sm border"
                    title="cделать главным"
                    type="button"
                    @click="removeFile(file, id)">
                        <i class="fa fa-close"></i>
                </button>
                <button
                    class="btn main-image btn-success btn-sm border"
                    v-if="type === 'images' && mainImage && mainImage.toString() === id"
                    title="главное"
                    type="button"
                    @click.prevent>
                        <i class="fa fa-check"></i>
                </button>
                <button
                    class="btn make-main-image btn-success btn-sm border"
                    v-if="type === 'images' && file.uploaded && mainImage !== id"
                    title="cделать главным"
                    type="button"
                    @click="makeMain(id)">
                        <i class="fa fa-check"></i>
                </button>
                <div class="progress progress-images" v-if="!file.uploaded">
                    <div class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    :style="{width: file.progress + '%'}"
                    :aria-valuenow="file.progress"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    </div>
                </div>
            </span>
            </div>
        </div>
        <div class="row justify-content-center mt-1" v-if="objectType === 'ZU'">
            <div class="col col-auto">
            <input
                v-if="file.id in files"
                class="form-control form-control-sm text-center border-0"
                type="text"
                :value="files[file.id].caption"
                placeholder="Подпись"
                @input="e => $emit('add-caption', file.id, e.target.value)"
                required/>
            </div>
        </div>
      </div>
    </template>
    <label :for="'files' + type" class="addButton"  v-if="type === 'images' && hasFiles">
      <i class="fa fa-plus" :title="headers.title"></i>
    </label>
    <div v-if="type === 'docs'" class="w-100">
        <div class="row pl-3 align-items-center" v-for="(file, id) in allFiles" :key="id">
            <div class="col col-auto mt-1">
                <button
                    class="btn btn-outline-danger btn-sm"
                    type="button"
                    @click="removeFile(file, id)">
                    удалить
                </button>
            </div>
            <div class="col col-auto">
                {{ file.original_filename ? file.original_filename : file.filename }}
            </div>
            <div class="col col-4">
                <div class="progress" v-if="!file.uploaded">
                    <div class="progress-bar progress-bar-striped bg-success"
                    role="progressbar"
                    :style="{width: file.progress + '%'}"
                    :aria-valuenow="file.progress"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>
        <label :for="'files' + type" v-if="hasFiles" class="btn">
            <span
                class="btn btn-outline-primary btn-sm"
                style="cursor: pointer;">
                Добавить
            </span>
        </label>
    </div>
    <input type="file" class="d-none" @change="addFiles" :id="'files' + type" multiple />
    <label :for="'files' + type" class="addFileDefault" v-if="!hasFiles">
      {{ headers.default }}
    </label>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.file-upload {
  min-height: 10rem;
  .img-thumbnail {
    height: 10rem;
  }
  .addButton {
    font-size: 8rem;
    line-height: 10rem;
    color: $gray-400;
    cursor: pointer;
  }
  .addButton:hover {
    color: $gray-600;
  }
  input[type="text"] {
    width: 8rem;
  }
  .addFileDefault {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    text-align: center;
    line-height: 10rem;
    cursor: pointer;
  }
  .image-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity .5s;
  }
  .image-bg p {
    line-height: normal;
  }
  .image-wrapper:hover .image-bg {
    opacity: .8;
  }
  .remove-image {
    position: absolute;
    top: .5rem;
    right: .5rem;
  }
  .main-image, .make-main-image {
    position: absolute;
    top: .5rem;
    left: .5rem;
  }
  .make-main-image {
    visibility: hidden;
  }
  .image-wrapper:hover .make-main-image {
    visibility: visible;
  }
  .progress-images {
    position: absolute;
    bottom: .5rem;
    left: 1%;
    width: 98%;
  }
}
</style>

<script>
import toastr from './elements/toastr';
import Http, { CancelToken, isCancel } from '../modules/Http';

export default {
  name: 'FileUpload',
  props: ['type', 'files', 'objectType'],
  data() {
    return {
      allFiles: {},
      mainImage: null,
    };
  },
  computed: {
    imageFolders() {
      return this.$store.state.imageFolders;
    },
    hasFiles() {
      return Object.keys(this.allFiles).length;
    },
    headers() {
      return this.type === 'images'
        ? {
          default: 'Загрузка изображений',
          title: 'Добавить изображение',
        } : {
          default: 'Загрузка документов',
          title: 'Добавить документ',
        };
    },
  },
  mounted() {
    Object.keys(this.files).forEach((id) => {
      const file = JSON.parse(JSON.stringify(this.files[id]));
      if (this.type === 'images') {
        file.src = this.imageFolders.small + file.filename;
        if (file.isMain) this.mainImage = file.id;
      }
      file.uploaded = true;
      this.$set(this.allFiles, file.id, file);
    });
  },
  methods: {
    addFiles(e) {
      const { files } = e.target;
      if (!files.length) return;
      Object.keys(files).forEach((num) => {
        const fileSrc = files[num];
        const tmpId = Math.random().toString();
        const file = {
          id: tmpId, filename: fileSrc.name, fileSrc, uploaded: false, progress: 0,
        };
        if (this.type === 'images') {
          if (!fileSrc.type.match(/jpeg|gif|bmp|png|jpg/i)) {
            toastr.warning(`Файл ${fileSrc.name} не является изображением`);
            return;
          }
          const fileReader = new FileReader();
          fileReader.onload = () => {
            file.src = fileReader.result;
            this.$set(this.allFiles, tmpId, file);
            this.upload(file);
          };
          fileReader.readAsDataURL(fileSrc);
        } else {
          this.$set(this.allFiles, tmpId, file);
          this.upload(file);
        }
      });
      e.target.value = null;
    },
    upload(file) {
      const formData = new FormData();
      const tmpId = file.id;
      formData.append('file', file.fileSrc);
      formData.append('type', this.type);
      Http.post('/files/upload', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        cancelToken: new CancelToken((c) => {
          this.allFiles[tmpId].cancelUpload = c;
        }),
        onUploadProgress: (progressEvent) => {
          this.allFiles[tmpId].progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        },
      }).then((response) => {
        this.$emit('uploaded', { ...response.data, caption: '', isMain: 0 }, this.type);
        this.allFiles[tmpId].uploaded = true;
        this.allFiles[tmpId].id = response.data.id;
        if (this.type === 'images' && !this.mainImage) this.makeMain(tmpId);
      }).catch((error) => {
        if (isCancel(error)) return;
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
          return;
        }
        toastr.warning('Что-то пошло не так, обратитесь к разработчикам');
      });
    },
    removeFile(file, id) {
      if (!file.uploaded) {
        file.cancelUpload();
      } else {
        this.$emit('removed', file.id, this.type);
      }
      this.$delete(this.allFiles, id);
      if (this.mainImage && id === this.mainImage.toString()) this.makeMain(null);
    },
    makeMain(tmpId) {
      const files = Object.keys(this.files);
      let mainImage = tmpId;
      if (!tmpId && files.length) {
        mainImage = Object.keys(this.allFiles).find(tmpIdIterate => this.allFiles[tmpIdIterate].id.toString() === files[0]);
      }
      this.mainImage = mainImage;
      const id = !mainImage ? null : this.allFiles[mainImage].id.toString();
      this.$emit('set-main-image', id);
    },
  },
};
</script>
