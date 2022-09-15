<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input v-model="title" type="text" class="form-control" id="title" placeholder="Enter Title">
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Post Content</label>
                            <textarea v-model="body" class="form-control" id="body" rows="3"
                                placeholder="Enter post details"></textarea>
                        </div>
                        <div class="mb-3">
                            <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"
                                @vdropzone-complete="afterUploadComplete" @vdropzone-sending-multiple="sendArticle">
                            </vue-dropzone>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" @click="saveArticleData">
                                Save Article
                            </button>
                        </div>
                    </div>

                </div>
                <div v-if="sendSuccess" class="card">
                    <div class="card-header">{{ article.title }}</div>
                    <div class="card-body">
                        <div class="text-center">
                            <template v-for="file in article.article_image">
                                <img :src="'/images/' + file.image.url" class="rounded img-thumbnail" alt="..." />
                            </template>
                        </div>
                        <div class="mt-3">
                            <p>{{ article.body }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    components: {
        vueDropzone: vue2Dropzone
    },
    data() {
        return {
            sendSuccess: false,
            title: "",
            body: "",
            article: {},
            uploadResponse: {},
            dropzoneOptions: {
                url: '/store-multiple-image',
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                thumbnailWidth: 150,
                maxFilesize: 2,
                parallelUploads: 3,
                maxFiles: 3,
                uploadMultiple: true,
                autoProcessQueue: false,
            }
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        afterUploadComplete: async function (response) {
            if (response.status == "success") {
                console.log("upload successful");
                this.uploadResponse = JSON.parse(response.xhr.response);
                this.getArticle()
                this.sendSuccess = true;
            } else {
                console.log("upload failed");
            }
        },
        saveArticleData: async function (props) {
            this.$refs.myVueDropzone.processQueue();
        },
        sendArticle: async function (files, xhr, formData) {
            formData.append("title", this.title);
            formData.append("body", this.body);
        },
        getArticle(){
            axios.get('/article/' + this.uploadResponse.data.id).then((res) => {
                this.article = res.data
            })
        }
    },
}
</script>
