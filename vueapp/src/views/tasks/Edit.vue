<template>
  <div class="flex items-center justify-center h-screen">
    <div class="">
    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
      {{ successMessage }}
    </div>
      <span
        v-if="validation.message"
        class="px-2 py-2 mb-4 text-red-600 rounded shadow"
      >
        {{ validation.message }}
      </span>
      <form @submit.prevent="submit">
        <div>
          <label for="title">Title</label>
          <input
            type="text"
            name="title"
            v-model="task.title"
            class="w-full px-4 py-2 border border-gray-300 outline-none"
          />
        </div>
        <div>
          <label for="details">Details</label>
          <textarea
            name="details"
            v-model="task.details"
            class="w-full px-4 py-2 border border-gray-300 outline-none"
            cols="10"
            rows="4"
          ></textarea>
        </div>
       <button class="btn-primary px-6 py-2 text-white bg-blue-600" type="submit">
          Update
        </button>
      </form>
    </div>
  </div>
</template>
<script>
import { reactive, ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
export default {
  setup() {
    const task = reactive({
      title: '',
      details: '',
    });
    const validation = ref([]);
   
    const router = useRouter();
    const route = useRoute();
    const successMessage = ref(''); // Declare successMessage as a ref
    
    onMounted(() => {
      // fetch api from laravel backend
      axios
        .get(`http://localhost:8082/api/tasks/${route.params.id}`)
        .then((response) => {
          task.title = response.data.data.title;
          task.details = response.data.data.details;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });
    function submit() {
      let title = task.title;
      let details = task.details;
      axios
        .put(`http://localhost:8082/api/tasks/${route.params.id}`, {
          title: title,
          details: details,
        })
        .then((res) => {
            if(res.data.success){
                successMessage.value = res.data.data;
            }
        })
        .catch((error) => {
            console.log(error);
          //validation.value = error.response.data;
        });
    }
    return {
      task,
      validation,
      router,
      submit,
      successMessage,
    };
  },
};
</script>
<style>
.btn{
  display: inline-block;
  font-weight: 400;
  color: #212529;
  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-primary {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
  margin-top:27px;
  padding:10px;
}

.btn-primary:hover {
  color: #fff;
  background-color: #0056b3;
  border-color: #0056b3;
}
  form {
    max-width: 420px;
    margin: 30px auto;
    background: #8f3737;
    text-align: left;
    padding: 40px;
    border-radius: 10px;
  }
  label {
    color: #aaa;
    display: inline-block;
    margin: 25px 0 15px;
    font-size: 0.6em;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: bold;
  }
  input, select, textarea {
    display: block;
    padding: 10px 6px;
    width: 100%;
    box-sizing: border-box;
    border: none;
    border-bottom: 1px solid #ddd;
    color: #555;
  }
</style>