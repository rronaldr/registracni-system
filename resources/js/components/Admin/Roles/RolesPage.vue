<template>
    <div class="row mb-3">
        <div class="col">
            <form @submit.prevent="findUser">
                <BaseInputWithSubmit
                    v-model="search"
                    type="text"
                    :label="$t('user.user_xname_email')"
                    :placeholder="$t('user.user_xname_email')"
                    :required="true"
                />
                <p v-if="error" class="text-danger">
                    {{ $t('user.not_found') }}
                </p>
            </form>

            <div v-if="user.id != null" class="mt-3">
                <form @submit.prevent="assignRole(selectedRole)">
                    <BaseSelectWithSubmit
                        v-model="selectedRole"
                        :placeholder="true"
                        :placeholder-text="$t('user.assign_role')"
                        :options="rolesParse"
                    />
                </form>

                <h5 class="mt-2">{{ user.email }}</h5>

                <UserRoleList
                    :user-id="user.id"
                    :roles="rolesUser"
                    @refresh-roles="refreshRoles"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { inject, reactive, ref } from 'vue'
import axios from 'axios'
import BaseInputWithSubmit from '../Form/BaseInputWithSubmit.vue'
import BaseSelectWithSubmit from '../Form/BaseSelectWithSubmit.vue'
import UserRoleList from './UserRoleList.vue'

const ADMIN_URL = inject('ADMIN_URL')
const props = defineProps({
    roles: { type: String, required: true }
})

let rolesParse = JSON.parse(props.roles)
let search = ref(null)
let error = ref(false)
let user = reactive({})
let rolesUser = ref(null)
let selectedRole = ref(null)

function findUser() {
    axios
        .get(ADMIN_URL + '/users/' + search.value)
        .then((response) => {
            error.value = false
            search.value = null

            user = response.data.user
            rolesUser.value = response.data.roles
        })
        .catch(() => {
            error.value = true
        })
}

async function refreshRoles() {
    await axios
        .get(ADMIN_URL + '/users/' + user.id + '/roles')
        .then((response) => {
            error.value = false
            search.value = null

            user = response.data.user
            rolesUser.value = response.data.roles
        })
        .catch(() => {
            error.value = true
        })
}

async function assignRole(roleId) {
    await axios.post(ADMIN_URL + '/users/' + user.id + '/roles/assign', {
        role: roleId
    })
    await refreshRoles()
}
</script>
