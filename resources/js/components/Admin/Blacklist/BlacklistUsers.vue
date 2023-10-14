<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5>
                        {{ $t('blacklist.users_on_blacklist') }}
                        <i
                            class="fas fa-info-circle"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Zde je seznam uživatelů, kteří jsou na globálním blacklistu"
                        ></i>
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table table-striped">
                <thead>
                    <tr>
                        <td>{{ $t('user.xname') }}</td>
                        <td>{{ $t('blacklist.blocked_until') }}</td>
                        <td>{{ $t('blacklist.block_reason') }}</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody v-if="users != null">
                    <BlacklistUser
                        v-for="user in users"
                        :key="user.id"
                        :user="user"
                        @refresh-users="getUsers()"
                    />
                </tbody>
                <span v-else>{{ $t('blacklist.no_users') }}</span>
            </table>
        </div>
    </div>
</template>

<script setup>
import { inject, ref } from 'vue'
import BlacklistUser from './BlacklistUser.vue'
import axios from 'axios'

const props = defineProps({
    blacklistId: { type: Number, required: true }
})
const ADMIN_URL = inject('ADMIN_URL')
let users = ref(null)

getUsers()

async function getUsers() {
    let response = await axios.get(
        ADMIN_URL + '/blacklist/' + props.blacklistId + '/users'
    )
    users.value = response.data.users
}

defineExpose({
    getUsers,
    users
})
</script>
