<template lang="">
  <div class="p-2 sm:ml-64">
    <div class="p-2 mt-12">
      <nav class="flex pb-4 py-2" aria-label="Breadcrumb">
        <ol
          class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse text-gray-700 from-blue-500 to-blue-700"
        >
          <li class="inline-flex items-center">
            <router-link
              ::to="{ name: 'Home' }"
              class="inline-flex items-center text-sm font-medium"
            >
              <svg
                class="w-3 h-3 me-2.5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
                />
              </svg>
              Dashboard
            </router-link>
          </li>
        </ol>
      </nav>
      <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="p-4 rounded-lg bg-gradient-to-tr from-pink-300 to-blue-300 shadow-lg">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">Total Product</h1>
            <p class="text-2xl font-bold py-2 text-dark-800">12</p>
          </div>
        </div>     
        <div class="p-4 rounded-lg bg-gradient-to-tr from-green-300 to-lime-200 shadow-lg">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">Total Customer</h1>
            <p class="text-2xl font-bold py-2 text-dark-800">12</p>
          </div>
        </div> 
        <div class="p-4 rounded-lg bg-gradient-to-tr from-red-300 to-orange-200 shadow-lg">
          <div>
            <h1 class="text-xl font-semibold text-gray-800">Total Order</h1>
            <p class="text-2xl font-bold py-2 text-dark-800">12</p>
          </div>
        </div>    
      </div>
    </div>
  </div>
</template>

<script setup></script>

