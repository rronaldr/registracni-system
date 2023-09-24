<template>
  <form @submit.prevent="addToBlacklist">
    <a class="link-secondary float-end" data-bs-toggle="modal" data-bs-target="#infoModal">
      <i class="fas fa-info-circle"></i> {{ $t('app.show-hint') }}
    </a>
    <BaseTextarea
        v-model="blacklist.users"
        :label="$t('blacklist.users')"
        class="mb-3"
        rows="3"
        required
    />
    <slot name="csrf"></slot>

    <SubmitButton/>
  </form>
</template>

<script setup>
import {reactive, inject} from 'vue'
import axios from 'axios'
import BaseTextarea from "../../Form/BaseTextarea.vue";
import SubmitButton from "../../Form/SubmitButton.vue";

const emit = defineEmits(['refreshUsers'])
const props = defineProps({
  blacklistId: {type: Number, required: true}
})
const ADMIN_URL = inject('ADMIN_URL')
let blacklist = reactive({users: null})

function addToBlacklist(){
  let csrf = document.getElementsByName('_token')[0].value
  let data = {
    blacklist: blacklist,
    _token: csrf
  }

  axios.put(
      ADMIN_URL+'/blacklist/'+ props.blacklistId,
      data
  ).then( (response) => {
    emit('refreshUsers')
    clearBlacklist()
  }).catch(error => {
    console.log(error)
  })
}
function clearBlacklist() {
  blacklist.users = null
}
</script>
