<template>
  <div class="container mt-5">
    <div class="row justify-content-center mb-5">
      <div class="col-12">
        <auth-data :user="user" :logout="logout"></auth-data>

        <!-- PARTICIPANT DATA -->
        <div class="card mb-2">
          <div class="card-header">Participant Data</div>
          <div class="card-body">
            <div class="col-12">
              Fullname: {{ participant.fullname }}
            </div>
            <div class="col-12">
              Email: {{ participant.email }}
            </div>
          </div>
        </div>

        <!-- ASPECT DATA -->
        <div class="card">
          <div class="card-header">Aspect Data</div>
          <div class="card-body">
            <div v-if="loading">
              <span>Fetching...</span>
            </div>
            <div v-else class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Aspect</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="data in aspect" :key="data.id">
                    <td>{{ data.name }}</td>
                    <td v-if="data.value === 1" class="text-center">
                      <i class="fa-solid fa-check" style="color: green"></i>
                    </td>
                    <td v-else></td>
                    <td v-if="data.value === 2" class="text-center">
                      <i class="fa-solid fa-check" style="color: green"></i>
                    </td>
                    <td v-else></td>
                    <td v-if="data.value === 3" class="text-center">
                      <i class="fa-solid fa-check" style="color: green"></i>
                    </td>
                    <td v-else></td>
                    <td v-if="data.value === 4" class="text-center">
                      <i class="fa-solid fa-check" style="color: green"></i>
                    </td>
                    <td v-else></td>
                    <td v-if="data.value === 5" class="text-center">
                      <i class="fa-solid fa-check" style="color: green"></i>
                    </td>
                    <td v-else></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <router-link class="btn btn-secondary" to="/participant">Back To List</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import method from "../axios/axios-setup";
import AuthData from "../components/AuthData.vue";
export default {
  components: { AuthData },
  props: { id: String },
  name: 'DetailParticipant',
  data() {
    return {
      participant: {},
      aspect: [],
      loading: false,
      user: {},
    }
  },
  methods: {
    userData() {
      this.user = this.$store.state.AuthUser
    },
    async logout() {
      await method.post('/api/logout').then(() => {
        localStorage.clear();
        window.location.reload()
      }).catch(() => {
        this.$swal("Error", "Internal Server Error", "error")
      })
    },
    async detailParticipant() {
      const id = this.$route.params.id
      this.loading = true;
      await method.get('/api/participant/' + id + '?with_relation=1')
        .then((res) => {
          const data = res.data.data.data;
          console.log(data)
          this.participant = {
            fullname: data.fullname,
            email: data.email,
          }
          this.aspect = data.aspect_value
          this.loading = false
        })
        .catch(err => {
          this.loading = false
          console.log(err);
          const status = err.response.status
          if (status === 401) {
            this.$swal("Failed", "Data not found", "error").then(() => {
              this.$router.push({ name: "Dashboard" })
            })
          } else {
            this.$swal("Failed", "Internal Server Error", "error").then(() => {
              this.$router.push({ name: "Dashboard" })
            })
          }
        })
    }
  },
  mounted() {
    this.detailParticipant()
    this.userData()
  }
}
</script>