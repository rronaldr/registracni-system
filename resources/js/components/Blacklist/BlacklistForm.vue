<template>
    <form @submit.prevent="addToBlacklist">
        <BaseInput
            v-model="blacklist.users"
            label="Xname"
            type="text"
        />
        <BaseInput
            v-model="blacklist.blockReason"
            :label="$t('blacklist.block_reason')"
            type="text"
        />
        <BaseInput
            v-model="blacklist.blocked_until"
            :label="$t('blacklist.block_until')"
            type="datetime-local"
        />

        <button type="submit">{{$t('app.submit')}}</button>
    </form>
</template>

<script setup>
import BaseInput from "../Form/BaseInput.vue"
import axios from 'axios'
import { ref, reactive } from 'vue'

const blacklist = reactive({users: null, blockReason: 'dddd', blocked_until: null})

function addToBlacklist(){
    console.log(blacklist)
}

</script>
