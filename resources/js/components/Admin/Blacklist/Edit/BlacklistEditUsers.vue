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
                        <th>{{ $t('user.xname') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <BlacklistEditUser
                        v-for="user in users"
                        :key="user.id"
                        :user="user"
                        @refresh-users="getUsers()"
                    />
                </tbody>
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
import BlacklistEditUser from './BlacklistEditUser.vue'

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

<style scoped>
.page-item.active .page-link {
    background-color: lightgrey !important;
    border: 1px solid black;
}
.page-link {
    color: black !important;
}
</style>