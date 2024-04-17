<template>

  <main class="container flex items-center justify-center h-screen mx-auto">
  <h1> Tasks List</h1>
  <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
      {{ successMessage }}
    </div>
    <div class="flex flex-col">
      <div class="overflow-x-auto">
        <div class="p-1.5 w-full inline-block align-middle">
          <RouterLink to="/tasks/create" class=" btn-primary p-2 text-white bg-blue-600"
            >Create</RouterLink
          >
          <div class=" table mt-3 overflow-hidden border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                  >
                    S.No.
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                  >
                    Title
                  </th>
                   <th
                    scope="col"
                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                  >
                    Details
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                  >
                    Actions 
                  </th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="(task, index) in tasks" :key="task.id">
                  <td
                    class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap"
                  >
                    {{ index + 1 }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                    {{ task.title }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                    {{ task.details }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                    <RouterLink
                      :to="{ name: 'tasks.edit', params: { id: task.id } }"
                      class="text-green-500"
                      >EDIT</RouterLink
                    >
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                    <button
                      @click.prevent="taskDelete(task.id, index)"
                      class="text-red-600"
                    >
                      DELETE
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
export default {
  setup() {
    let tasks = ref([]);
    const successMessage = ref(''); // Define success message variable
    const router = useRouter();

    onMounted(() => {
      // fetch api from laravel backend
      axios
        .get('http://localhost:8082/api/tasks')
        .then((res) => {
            console.log(res.data);
          tasks.value = res.data.data;
        })
        .catch((error) => {
          console.log(error.res.data);
        });
    });
    function taskDelete(id, index) {
      axios
        .delete(`http://localhost:8082/api/tasks/${id}`)
        .then((res, index) => {
            const indexToRemove = tasks.value.findIndex(task => task.id === id);

            // Check if the index is valid (-1 indicates not found)
            if (indexToRemove !== -1) {
            // Remove the task at the found index
                tasks.value.splice(indexToRemove, 1);
            }
            successMessage.value = 'Task is deleted successfully.';
        })
        .catch((error) => {
          console.log(error);
        });
    }
    return {
      tasks,
      taskDelete,
      successMessage,
      router,
    };
  },
};
</script>
<style>
/* Styles for buttons */
.btn {
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
}

.btn-primary:hover {
  color: #fff;
  background-color: #0056b3;
  border-color: #0056b3;
}

/* Styles for table */
.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}
</style>