import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Tasks from '../views/tasks/Index.vue'
import TaskCreate from '../views/tasks/Create.vue'
import TaskEdit from '../views/tasks/Edit.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    },{
      path: '/tasks',
      name: 'tasks',
      component: Tasks
    },
    {
      path: '/tasks/create',
      name: 'tasks.create',
      component: TaskCreate
    },
    {
      path: '/tasks/:id',
      name: 'tasks.edit',
      component: TaskEdit
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router
