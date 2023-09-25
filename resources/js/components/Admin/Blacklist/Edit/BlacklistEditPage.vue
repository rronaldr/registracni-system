<template>
  <div class="row mb-3">
    <div class="col-md-12">
      <BlacklistEditUsers
          :blacklist-id="blacklistId"
          ref="listRef"
      />
    </div>
  </div>

  <div class="row mb-3">
    <div class="col">
      <BlacklistEditForm
          :blacklist-id="blacklistId"
          @refresh-users="refreshUsers()"
      >
        <template v-slot:csrf>
          <slot name="csrf"></slot>
        </template>
      </BlacklistEditForm>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import BlacklistEditForm from "./BlacklistEditForm.vue";
import BlacklistEditUsers from "./BlacklistEditUsers.vue";

const props = defineProps({
  blacklistId: {type: Number, required: true}
})

const listRef = ref(null)

function refreshUsers() {
  listRef.value.getUsers()
}
</script>
