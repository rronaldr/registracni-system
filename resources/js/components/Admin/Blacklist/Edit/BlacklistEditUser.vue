<template>
    <tr>
        <td>{{ user.xname ?? '-' }}</td>
        <td class="text-right">
            <button
                type="button"
                title="{{ $t('app.delete') }}"
                class="btn-link text-danger border-0"
                @click="removeUserFromBlacklist"
            >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script setup>
import { inject } from 'vue'
import axios from 'axios'

const props = defineProps({
    user: { type: Object, required: true }
})
const emit = defineEmits(['refreshUsers'])
const ADMIN_URL = inject('ADMIN_URL')

function removeUserFromBlacklist() {
    axios.delete(
        ADMIN_URL +
            '/blacklist/' +
            props.user.pivot.blacklist_id +
            '/' +
            props.user.id
    )
    emit('refreshUsers')
}
</script>
