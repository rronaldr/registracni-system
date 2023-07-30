<template>
    <tr>
        <td>{{ user.xname ?? '-'}}</td>
        <td>{{ user.pivot.blocked_until ?? '-' }}</td>
        <td>{{ user.pivot.block_reason ?? '-'}}</td>
        <td>
            <button @click="removeUserFromBlacklist" title="{{ $t('app.delete') }}" class="btn btn-outline-danger btn-rounded"> <i class="fas fa-trash"></i></button>
        </td>
    </tr>
</template>

<script setup>
    import {inject} from "vue";

    const props = defineProps({
        user: {type: Object, required: true},
    })
    const emit = defineEmits(['refreshUsers'])
    const ADMIN_URL = inject('ADMIN_URL')

    function removeUserFromBlacklist() {
        axios.delete(
            ADMIN_URL+'/blacklist/'+props.user.pivot.blacklist_id+'/'+props.user.id
        )
        emit('refreshUsers')
    }
</script>
