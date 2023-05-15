<template>
  <div class="container mt-5">
    <div class="row d-flex justify-content-center">
      <div class="col-12">

        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <form autocomplete="off" @submit.prevent="login" method="post">
              <!-- Email input -->
              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Username</label>
                <input type="text" id="username" class="form-control" placeholder="username" v-model="username" required>
              </div>
              <!-- Password input -->
              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Password</label>
                <input type="password" v-model="password" id="form2Example2" class="form-control" required />
              </div>
              <!-- Submit button -->
              <button :disabled="loading" type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
export default {
  data() {
    return {
      username: null,
      password: null,
      loading: false,
    }
  },
  methods: {
    /** 
     * LOGIN PROCESS
    */
    async login() {
      this.loading = true;
      let formData = new FormData();
      formData.append('username', this.username)
      formData.append('password', this.password);
      await axios.post('api/login', formData)
        .then(res => {
          const data = res.data.data;
          const token = data.token;
          const user = data.user;
          console.log(this.$store.state.Authenticated);
          this.$store.commit('SET_AUTHUSER', user)
          this.$store.commit('SET_AUTHENTICATED', true)
          this.$store.commit('SET_ADMIN', user.is_admin)
          this.$store.commit('SET_TOKEN', token)
          localStorage.setItem('token', token)
          localStorage.setItem('auth', 1)
          this.loading = false
          window.location.reload();
        }).catch(err => {
          const errStatus = err.response.status
          if (errStatus == 401) {
            this.$swal("Failed", "Username or password wrong", "error")
          } else if (errStatus == 422) {
            this.$swal("Failed", "All Field is Required", "error")
          } else {
            this.$swal("Failed", "Internal server error", "error")
          }
          this.loading = false;
        })
    }
  },
}
</script>