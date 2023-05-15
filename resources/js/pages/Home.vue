<template>
  <div class="container mt-5">
    <div class="row justify-content-center mb-5">
      <!-- MODAL CREATE -->
      <b-modal size="xl" centered v-model="modalAdd" :ok-disabled="loadingCreate"
        :ok-title="loadingCreate ? 'Loading...' : 'Submit'" @ok="handleOk" ok-type="submit">
        <form ref="form" method="post" @submit.stop.prevent="handleCreate">
          <ul v-if="errorSubmit.create">
            <li style="color: red" v-for="(message, key) in errMessage" :key="key">
              {{ message[0] }}
            </li>
          </ul>
          <div class="form-group">
            <label for="fullname">Fullname</label>
            <input type="text" v-model="formAdd.fullname" required name="fullname" id="fullname" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" v-model="formAdd.email" required name="email" id="email" class="form-control">
          </div>
          <div class="form-group">
            <label for="x">X Value</label>
            <input type="number" v-model="formAdd.x" min="1" max="33" required name="x" id="x" class="form-control">
          </div>
          <div class="form-group">
            <label for="y">Y Value</label>
            <input type="number" v-model="formAdd.y" min="1" max="23" required name="y" id="y" class="form-control">
          </div>
          <div class="form-group">
            <label for="z">Z Value</label>
            <input type="number" v-model="formAdd.z" min="1" max="18" required name="z" id="z" class="form-control">
          </div>
          <div class="form-group">
            <label for="w">W Value</label>
            <input type="number" v-model="formAdd.w" min="1" max="13" required name="w" id="w" class="form-control">
          </div>
          <button type="submit" style="visibility:hidden"></button>
        </form>
      </b-modal>

      <!-- MODAL EDIT -->
      <b-modal size="xl" centered v-model="modalEdit" :ok-disabled="loadingModalEdit"
        :ok-title="loadingModalEdit ? 'Loading...' : 'Save'" @ok="handleOkEdit" ok-type="submit">
        <div v-if="loadingModalEdit">
          <h5>Fetching....</h5>
        </div>
        <div v-else>
          <form ref="form-1" method="post" @submit.stop.prevent="handleEdit">
            <ul v-if="errorSubmit.update">
              <li style="color: red" v-for="(message, key) in errMessage" :key="key">
                {{ message[0] }}
              </li>
            </ul>
            <div class="form-group">
              <label for="fullname">Fullname</label>
              <input type="text" v-model="formEdit.fullname" required name="fullname" id="fullname" class="form-control">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" v-model="formEdit.email" required name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="x">X Value</label>
              <input type="number" v-model="formEdit.x" min="1" max="33" required name="x" id="x" class="form-control">
            </div>
            <div class="form-group">
              <label for="y">Y Value</label>
              <input type="number" v-model="formEdit.y" min="1" max="23" required name="y" id="y" class="form-control">
            </div>
            <div class="form-group">
              <label for="z">Z Value</label>
              <input type="number" v-model="formEdit.z" min="1" max="18" required name="z" id="z" class="form-control">
            </div>
            <div class="form-group">
              <label for="w">W Value</label>
              <input type="number" v-model="formEdit.w" min="1" max="13" required name="w" id="w" class="form-control">
            </div>
            <button type="submit" style="visibility:hidden"></button>
          </form>
        </div>
      </b-modal>
      <div class="col-12">
        <auth-data :user="user" :logout="logout"></auth-data>
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <div class="col-6">
                <h5>Participant List</h5>
              </div>
              <div class="col-6">
                <button :disabled="!user.is_admin"
                  :style="!user.is_admin ? 'cursor: not-allowed !important' : 'cursor: pointer'"
                  class="btn btn-primary float-right" @click="modalAdd = !modalAdd">Add</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div v-if="loading">
              <span>Fetching....</span>
            </div>
            <div v-else class="table-responsive">
              <table class="table table-bordered" id="my-table">
                <thead>
                  <tr>
                    <th scope="col" style="border-bottom: none;"></th>
                    <th scope="col" style="border-bottom: none;"></th>
                    <th scope="col" colspan="4" class="text-center">Nilai</th>
                    <th scope="col" style="border-bottom: none;"></th>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th style="border-top: none;">Nama</th>
                    <th style="border-top: none;">Email</th>
                    <th>X</th>
                    <th>Y</th>
                    <th>Z</th>
                    <th>W</th>
                    <th style="border-top: none;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="participant in data" :key="participant.id">
                    <td>{{ participant.fullname }}</td>
                    <td>{{ participant.email }}</td>
                    <td>{{ participant.x }}</td>
                    <td>{{ participant.y }}</td>
                    <td>{{ participant.z }}</td>
                    <td>{{ participant.w }}</td>
                    <td>
                      <div>
                        <b-dropdown id="dropdown-1" text="Action" class="m-md-2">
                          <b-dropdown-item-button @click="detail(participant.id)">Detail</b-dropdown-item-button>
                          <b-dropdown-item-button v-if="user.is_admin"
                            @click="editParticipant(participant.id)">Edit</b-dropdown-item-button>
                          <b-dropdown-item-button v-if="user.is_admin" @click="deleteParticipant(participant.id)">Delete</b-dropdown-item-button>
                        </b-dropdown>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <b-pagination @change="pageHandler" v-model="currentPage" :total-rows="totalRows" first-number last-number
                aria-controls="my-table"></b-pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import method from '../axios/axios-setup'
import AuthData from '../components/AuthData.vue'
export default {
  components: { AuthData },
  name: 'Dashboard',
  data() {
    return {
      data: [],
      currentPage: 1,
      maxPage: 1,
      totalRows: 1,
      loading: false,
      loadingCreate: false,
      loadingEdit: false,
      modalAdd: false,
      modalEdit: false,
      loadingModalEdit: false,
      user: {},
      formAdd: {
        fullname: '',
        email: '',
        x: 0,
        y: 0,
        z: 0,
        w: 0
      },
      formEdit: {
        id: '',
        fullname: '',
        email: '',
        x: 0,
        y: 0,
        z: 0,
        w: 0
      },
      errorSubmit: {
        create: false,
        update: false,
      },
      errMessage: [],
    }
  },
  methods: {
    async pageHandler(page) {
      this.currentPage = page
      await this.getParticipant()
    },
    async getParticipant() {
      this.loading = true
      await method.get(`api/participant?page=${this.currentPage}`)
        .then(res => {
          const data = res.data.data
          this.currentPage = data.pagination.current_page
          this.maxPage = data.pagination.last_age
          this.totalRows = data.pagination.total
          this.data = data.data
          this.loading = false;
        }).catch((err) => {
          console.log(err)
          this.loading = false;
          this.$swal("Failed", "Internal Server Error", "error")
        })
    },
    async handleOk(modalEvent) {
      modalEvent.preventDefault()
      await this.handleCreate()
    },
    async handleOkEdit(modalEvent) {
      modalEvent.preventDefault();
      await this.handleEdit()
    },
    async handleEdit() {
      this.loadingEdit = true;
      const id = this.formEdit.id
      await method.put(`api/participant/${id}`, this.formEdit)
        .then(async () => {
          this.loadingEdit = false
          this.errorSubmit.update = false
          this.$swal("Success", "Participant Updated Successfully", "success")
          this.modalEdit = false
          this.errMessage = []
          this.formEdit = {
            id: '',
            fullname: '',
            email: '',
            x: 0,
            y: 0,
            z: 0,
            w: 0
          }
          await this.getParticipant()
        }).catch(err => {
          this.loadingEdit = false;
          const status = err.response.status
          const errMessage = err.response.data.error
          if (status === 403) {
            this.$swal("Failed", "You do not have access to make this Request", "error")
          } else if (status === 422) {
            this.errorSubmit.update = true
            this.errMessage = errMessage
          } else {
            this.$swal("Failed", "Internal Server Error", "error")
          }
        })
    },
    async handleCreate() {
      this.loadingCreate = true;
      let formData = new FormData();
      formData.append('fullname', this.formAdd.fullname)
      formData.append('email', this.formAdd.email)
      formData.append('x', this.formAdd.x)
      formData.append('y', this.formAdd.y)
      formData.append('z', this.formAdd.z)
      formData.append('w', this.formAdd.w)
      await method.post('api/participant', formData)
        .then(async () => {
          this.errorSubmit.create = false;
          this.loadingCreate = false
          this.currentPage = 1
          this.errMessage = []
          this.$swal("Success", "Participant Created Successfully", "success")
          this.modalAdd = false
          this.formAdd = {
            fullname: '',
            email: '',
            x: 0,
            y: 0,
            z: 0,
            w: 0
          }
          await this.getParticipant()
        }).catch(err => {
          this.loadingCreate = false
          const status = err.response.status
          const errMessage = err.response.data.error
          if (status === 403) {
            this.$swal("Failed", "You do not have access to make this Request", "error")
          } else if (status === 422) {
            this.errorSubmit.create = true
            this.errMessage = errMessage
          } else {
            this.$swal("Failed", "Internal Server Error", "error")
          }
        })
    },
    async editParticipant(id) {
      this.modalEdit = true;
      this.loadingModalEdit = true;
      await method.get(`api/participant/${id}?with_relation=0`)
        .then(res => {
          const data = res.data.data.data;
          this.formEdit = {
            id: data.id,
            fullname: data.fullname,
            email: data.email,
            x: data.x,
            y: data.y,
            z: data.z,
            w: data.w
          }
          this.loadingModalEdit = false;
        }).catch(err => {
          this.loadingModalEdit = false;
          const errStatus = err.response.status
          if (errStatus === 404) {
            this.$swal("Failed", "Data not found. Please refresh new data", "error")
          } else {
            this.$swal("Failed", "Internal Server Error", "error")
          }
        })
    },
    async deleteParticipant(id) {
      this.$swal({
        title: "Are You Sure Want To Delete?",
        text: "You will not be able to revert this action",
        icon: "warning",
        dangerMode: true,
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        showCancelButton: true,
      }).then(async (result) => {
        if (result.value) {
          await method.delete(`api/participant/${id}`)
            .then(() => {
              this.$swal("Success", "Participant Deleted Successfully", "success")
              this.getParticipant()
            }).catch(err => {
              const status = err.response.status
              if (status === 403) {
                this.$swal("Failed", "You do not have access to make this Request", "error")
              } else if (status === 401) {
                this.$swal("Failed", "Data not found", "error")
              } else {
                this.$swal("Failed", "Internal Server Error", "error")
              }
            })
        } else {
          return null
        }
      })
    },
    detail(id) {
      this.$router.push({name: "DetailParticipant", params: { id: id}});
    },
    userData() {
      this.user = this.$store.state.AuthUser
    },
    async logout() {
      await method.post('api/logout').then(() => {
        localStorage.clear();
        window.location.reload()
      }).catch(() => {
        this.$swal("Error", "Internal Server Error", "error")
      })
    }
  },
  mounted() {
    this.getParticipant()
    this.userData()
  }
}
</script>
