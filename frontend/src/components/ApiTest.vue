<script>
export default {
  data: () => ({
    apiResponse: null
  }),

  created() {
    let v = this
    v.fetchData()
    setInterval(()=>{
      v.fetchData(true)
    }, 3000)
  },

  methods: {
    async fetchData(reload = false) {
      let url = 'http://localhost/'
      if (reload) url = url + '?reload=1'
      this.apiResponse = await (await fetch(url)).json()
    }
  }
}
</script>

<template>
  <div class="relative mx-auto w-full max-w-7xl items-center justify-between gap-x-6 p-6 lg:px-8">
    <div v-if="!apiResponse">
      <div class="mt-[40vh] flex items-center justify-center space-x-2">
        <div
          class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
          role="status">
          <span
            class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
            >Loading...</span
          >
        </div>
      </div>
    </div>

    <div v-if="apiResponse">
      <div class="mt-8 flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                  <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Email</th>
                  <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Latitude</th>
                  <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Longitude</th>
                  <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Weather</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">View</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="(user, index) in apiResponse">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ user.name }}</td>
                  <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ user.email }}</td>
                  <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ user.latitude }}</td>
                  <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ user.longitude }}</td>
                  <td class="whitespace-nowrap py-1 px-3 text-sm text-gray-500">
                    <span v-if="user.weather" class="flex items-center justify-between"><span><img :src="'https://openweathermap.org/img/wn/'+user.weather.weather[0].icon+'.png'" width="40" height="40"/>{{ user.weather.weather[0].main }}</span> {{user.weather.main.temp}} &#8451;</span>
                    <span v-else>No Data</span>
                  </td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                    <router-link :to="{ name: 'user', params: { id: user.id } }" class="text-indigo-600 hover:text-indigo-900">View</router-link>
                  </td>
                </tr>

                <!-- More people... -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>