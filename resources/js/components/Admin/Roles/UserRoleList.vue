<template>
    <div class="table-responsive">
        <table class="table table table-striped">
            <thead>
            <tr>
                <td>{{ $t('user.role_name') }}</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <UserRoleItem
                v-if="roles.length > 0"
                v-for="role in roles"
                :key="role.id"
                :role="role"
                @revoke-role="revokeRole"
            />
            <tr v-else>{{ $t('user.user_no_roles') }}</tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import UserRoleItem from "./UserRoleItem.vue";
import {inject} from "vue";
import axios from "axios";

const ADMIN_URL = inject('ADMIN_URL')
const emit = defineEmits(['refreshRoles'])
const props = defineProps({
    user_id: {type: Number, required: true},
    roles: {type: Array, required: true}
})

async function revokeRole(id) {
    await axios.post(ADMIN_URL+'/users/'+props.user_id+'/roles/revoke', {
        'role': id
    })
    emit('refreshRoles')
}
</script>
