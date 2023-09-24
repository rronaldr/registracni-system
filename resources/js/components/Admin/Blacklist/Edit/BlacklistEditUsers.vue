<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col">
          <h5>
            Uživatelé na blacklistu
            <i class="fas fa-info-circle"
               data-toggle="tooltip" data-placement="top"
               title="Zde je seznam uživatelů, kteří jsou na globálním blacklistu"></i>
          </h5>
        </div>
      </div>
    </div>
    <div class="card-body">
      <table class="table table table-striped">
        <thead>
        <tr>
          <td>{{ $t('user.xname') }}</td>
          <td></td>
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
    </div>
  </div>
</template>

<script setup>
import {inject, ref} from "vue";
import BlacklistEditUser from "./BlacklistEditUser.vue";

const props = defineProps({
  blacklistId: {type: Number, required: true}
})
const ADMIN_URL = inject('ADMIN_URL')
let users = ref(null)

getUsers()

async function getUsers() {
  let response = await axios.get(
      ADMIN_URL+'/blacklist/'+props.blacklistId+'/users'
  )
  users.value = response.data.users
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
