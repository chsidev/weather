<script>
export default {
  data: () => ({
    userData: null
  }),

  created() {
    this.fetchData(this.$route.params.id)
  },

  methods: {
    async fetchData(uid) {
      const url = 'http://localhost/user/'+uid
      this.userData = await (await fetch(url)).json()
    }
  }
}
</script>

<template>
  <div class="relative mx-auto w-full max-w-7xl items-center justify-between gap-x-6 p-6 lg:px-8">
    <div v-if="!userData">
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

    <div v-if="userData">
      <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-base font-semibold leading-6 text-gray-900">Applicant Information</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
          <dl class="sm:divide-y sm:divide-gray-200">
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Name</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{userData.name}}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Email address</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{userData.email}}</dd>
            </div>
            
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Weather</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <p><span class="font-bold inline-block w-[100px]">Data: </span> <img :src="'https://openweathermap.org/img/wn/'+userData.weather.weather[0].icon+'@2x.png'" width="80" height="80"/></p>
                <p><span class="font-bold inline-block w-[100px]">Main: </span> {{ userData.weather.weather[0].main }}</p><br>
                <p><span class="font-bold inline-block w-[100px]">Temperature: </span> {{userData.weather.main.temp}} &#8451;</p><br>
                <p><span class="font-bold inline-block w-[100px]">Feel Like: </span> {{userData.weather.main.feel_like}} &#8451;</p><br>
                <p><span class="font-bold inline-block w-[100px]">Temp Min: </span> {{userData.weather.main.temp_min}} &#8451;</p><br>
                <p><span class="font-bold inline-block w-[100px]">Temp Max: </span> {{userData.weather.main.temp_max}} &#8451;</p><br>
                <p><span class="font-bold inline-block w-[100px]">Feel Like: </span> {{userData.weather.main.feel_like}} &#8451;</p><br>
                <p><span class="font-bold inline-block w-[100px]">Humidity: </span> {{userData.weather.main.humidity}} %</p><br>
                <p><span class="font-bold inline-block w-[100px]">Lat: </span> {{ userData.weather.coord.lat }}</p><br>
                <p><span class="font-bold inline-block w-[100px]">Lng: </span> {{ userData.weather.coord.lon }}</p><br>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </div>
</template>