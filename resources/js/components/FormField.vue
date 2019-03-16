<template>
    <default-field :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
            <div @mouseover="setValue" @keyup="setValue" :class="[errorClasses, errorClasses.length ? 'border' : '']" @keydown.stop>
            <textarea
                :id="field.attribute"
                :dusk="field.attribute"
                v-model="value"
            />
            </div>

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </default-field>
</template>

<style lang="scss" src="../../css/css.scss"></style>
<style lang="scss" src="../../css/app.scss"></style>

<script>
import "summernote/dist/summernote-lite";
import 'summernote/dist/summernote-lite.css';
import 'summernote/dist/lang/summernote-ko-KR.min';
import 'codemirror/lib/codemirror';
import 'codemirror/lib/codemirror.css';
import 'codemirror/addon/edit/matchbrackets';
import 'codemirror/mode/htmlmixed/htmlmixed';
import 'codemirror/mode/xml/xml';
import 'codemirror/mode/javascript/javascript';
import 'codemirror/mode/css/css';
import 'codemirror/mode/clike/clike';
import 'codemirror/mode/php/php';
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    computed: {
        options() {
            let options = this.field.options

            return options
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            this.switchHtmlCodeViewToNormalView();
            this.setValue();
            if (stripTags(this.value).length === 0) {
                this.value = '';
            }
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        setValue() {
            let vm = this;
            this.value = $(vm.$el).find('.note-editable').html().replace('=&gt;', '=>');
        },

        switchHtmlCodeViewToNormalView() {
            try {
                $(this.$el).find('.btn-codeview.active').click();
            } catch(e) {
                // just ignore
            };
        },

        fileManager() {
            let vm = this;

            // Define function to open filemanager window
            const lfm = function (options, cb) {
                var route_prefix = (vm.options && vm.options.lfm_prefix) ? vm.options.lfm_prefix : '/laravel-filemanager';
                window.open(route_prefix + '?type=' + vm.options.lfm_type || 'file', 'FileManager', 'width=900,height=600');
                window.SetUrl = cb;
            };

            // Define LFM summernote button
            const LFMButton = function (context) {
                const ui = $.summernote.ui;
                const button = ui.button({
                    contents: '<i class="note-icon-picture"></i>',
                    container: $('body'), // fix for tooltip display
                    tooltip: '파일 관리자를 이용해서 이미지 추가하기',
                    click: function () {
                        lfm({type: 'image', prefix: '/laravel-filemanager'}, function (lfmItem, path) {
                            context.invoke('insertImage', lfmItem);
                        });
                    }
                });

                return button.render();
            };

            // Initialize summernote with LFM button in the popover button group
            // Please note that you can add this button to any other button group you'd like
            $(this.$el).find('textarea').summernote({
                lang: 'ko-KR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['lfm', 'link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                buttons: {
                    lfm: LFMButton
                },
                prettifyHtml: false,
                codemirror: {
                    lineNumbers: true,
                    matchBrackets: true,
                    mode: 'application/x-httpd-php',
                    indentUnit: 4,
                    indentWithTabs: true,
                    lineWrapping: false,
                },
            })
        },
    },

    mounted() {
        let vm = this;

        $(document).ready(function() {
            if (vm.options.use_lfm) {
                vm.fileManager();
            } else {
                $(vm.$el).find('textarea').summernote();
            }
        });
    },

}

function stripTags(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;

    return tmp.textContent || tmp.innerText || "";
}
</script>
