<template>
    <form @submit.prevent="addToBlacklist">
        <a class="link-secondary float-end" data-toggle="modal" data-target="#infoModal">
            <i class="fas fa-info-circle"></i> {{ $t('app.show-hint') }}
        </a>
        <br/>
        <BaseTextarea
            v-model="blacklist.users"
            :label="$t('blacklist.users')"
            class="mb-3"
            rows="3"
            required
        />
        <BaseInput
            v-model="blacklist.block_reason"
            :label="$t('blacklist.block_reason')"
            type="text"
            class="mb-3"
        />
        <BaseInput
            v-model="blacklist.blocked_until"
            :label="$t('blacklist.blocked_until')"
            type="datetime-local"
            class="mb-3"
        />
        <slot name="csrf"></slot>

        <FormButtons
            :route="ADMIN_URL+'/events'"
        />
    </form>
</template>

<script setup>
import {reactive, inject, onMounted} from 'vue'
import axios from 'axios'
import BaseInput from "../Form/BaseInput.vue"
import BaseTextarea from "../Form/BaseTextarea.vue";
import FormButtons from "../Form/FormButtons.vue";

const emit = defineEmits(['refreshUsers'])
const props = defineProps({
    blacklistId: {type: Number, required: true}
})
const ADMIN_URL = inject('ADMIN_URL')
let blacklist = reactive({users: null, block_reason: null, blocked_until: null})

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
    blacklist.block_reason = null
    blacklist.blocked_until = null
}
</script>
