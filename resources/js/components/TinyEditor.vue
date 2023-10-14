<template>
    <Editor
        api-key="6kz4ky7ixdl549cg6caz3f4hnjl4vhwa4f3ixy4qjrol04a5"
        :initial-value="content"
        :init="{
            language: 'cs',
            height: 400,
            branding: false,
            menubar: false,
            plugins:
                'searchreplace autolink visualchars fullscreen image link media codesample table charmap nonbreaking anchor insertdatetime advlist lists wordcount code',
            toolbar:
                'insert | undo redo |  formatselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink removeformat code',
            image_advtab: true,
            //paste_as_text: true
            paste_auto_cleanup_on_paste: true,
            paste_remove_spans: true,
            paste_remove_styles: true,
            paste_strip_class_attributes: 'all'
        }"
    />
</template>

<script setup>
import Editor from '@tinymce/tinymce-vue'

defineProps({
    content: { type: String, required: false, default: null }
})
</script>
