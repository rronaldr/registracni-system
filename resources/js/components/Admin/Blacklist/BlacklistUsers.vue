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
                            :title="$t('blacklist.users_hint')"
                        ></i>
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
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

            <Bootstrap4Pagination
                :data="responseData"
                @pagination-change-page="getUsers"
            />
        </div>
    </div>
</template>

<script setup>
import { inject, ref } from 'vue'
import { Bootstrap4Pagination } from 'laravel-vue-pagination'
import axios from 'axios'
import BlacklistUser from './BlacklistUser.vue'

const props = defineProps({
    blacklistId: { type: Number, required: true }
})
const ADMIN_URL = inject('ADMIN_URL')
let users = ref(null)
let responseData = ref({})

getUsers()

async function getUsers(page = 1) {
    let response = await axios.get(
        ADMIN_URL + '/blacklist/' + props.blacklistId + `/users?page=${page}`
    )
    responseData.value = response.data
    users.value = response.data.data
}

defineExpose({
    getUsers,
    users
})
</script>
