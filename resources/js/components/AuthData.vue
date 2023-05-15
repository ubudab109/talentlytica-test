<template>
  <div class="card mb-5">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div class="col-6">
          <h5>Hello, {{ user.name }}</h5>
          <h5>
            {{ user.is_admin ? "Your Role is Admin" : "Your Role is User" }}
          </h5>
        </div>
        <div class="col-6">
          <button class="btn btn-secondary float-right" @click="logout">Logout</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "AuthDataComponent",
  props: {
    user: {
      type: Object,
      required: true,
      default: () => {}
    },
    logout: {
      type: Function,
      required: false,
    }
  },
}
</script>