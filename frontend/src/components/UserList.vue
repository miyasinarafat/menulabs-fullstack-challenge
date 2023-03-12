<template>
  <div class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:py-40 lg:px-8">
      <div class="mx-auto max-w-4xl divide-y divide-gray-900/10">
        <h2 class="text-4xl font-bold leading-10 tracking-tight text-gray-900">User List</h2>
        <dl class="mt-10 space-y-6 divide-y divide-gray-900/10">
          <Disclosure as="div" v-for="user in data" :key="user.id" class="pt-6" v-slot="{ open }">
            <dt>
              <DisclosureButton class="flex w-full items-start justify-between text-left text-gray-900">
                <span class="text-base font-semibold leading-7">{{ user.name }} - {{ user.email }}</span>
                <span class="ml-6 flex h-7 items-center">
                  <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true" />
                  <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true" />
                </span>
              </DisclosureButton>
            </dt>
            <DisclosurePanel as="dd" class="mt-2 pr-12">
              <div class="flex items-center justify-center mt-16 mb-16">
                <div class="flex flex-col bg-white rounded p-4 w-full max-w-xs drop-shadow-2xl">
                  <div class="font-bold text-xl">{{ user.weather?.city }}</div>
                  <div class="text-sm text-gray-500">{{ user.weather?.dateTime }}</div>
                  <div class="mt-6 text-6xl self-center inline-flex items-center justify-center rounded-lg text-indigo-400 h-24 w-24 drop-shadow-xl">
                    <img class="w-32 h-32 object-cover" :src="user.weather?.iconUrl">
                  </div>
                  <div class="flex flex-row items-center justify-center mt-6">
                    <div class="font-medium text-5xl">{{ user.weather?.temperature }}°</div>
                    <div class="flex flex-col items-center ml-6">
                      <div>{{ user.weather?.status }}</div>
                      <div class="mt-1">
                        <span class="text-sm"><i class="far fa-long-arrow-up"></i></span>
                        <span class="text-sm font-light text-gray-500">{{ user.weather?.temperatureMax }}°C</span>
                      </div>
                      <div>
                        <span class="text-sm"><i class="far fa-long-arrow-down"></i></span>
                        <span class="text-sm font-light text-gray-500">{{ user.weather?.temperatureMin }}°C</span>
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-row justify-between mt-6">
                    <div class="flex flex-col items-center">
                      <div class="font-medium text-sm">Wind</div>
                      <div class="text-sm text-gray-500">{{ user.weather?.windSpeed }}m/s</div>
                    </div>
                    <div class="flex flex-col items-center">
                      <div class="font-medium text-sm">Humidity</div>
                      <div class="text-sm text-gray-500">{{ user.weather?.humidity }}%</div>
                    </div>
                    <div class="flex flex-col items-center">
                      <div class="font-medium text-sm">Visibility</div>
                      <div class="text-sm text-gray-500">{{ user.weather?.visibility/1000 }}km</div>
                    </div>
                  </div>
                </div>
              </div>
            </DisclosurePanel>
          </Disclosure>
        </dl>
        <hr class="mt-10">
      </div>
      <div class="mt-6 mx-auto max-w-4xl">
        <VuePaginationTw
            :current-page="currentPage"
            :total-items="total"
            :per-page="perPage"
            @page-changed="onPageClick($event)"
            :go-button="false"
        />
      </div>
    </div>
  </div>
</template>

<script>
// import "vue-pagination-tw/styles";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { MinusSmallIcon, PlusSmallIcon } from "@heroicons/vue/24/outline";
// import VuePaginationTw from "vue-pagination-tw";
import VuePaginationTw from "./vue-pagination-tw.vue";

export default {
  components: {
    VuePaginationTw,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    MinusSmallIcon,
    PlusSmallIcon,
  },
  data: () => ({
    data: [],
    currentPage: 1,
    perPage: 10,
    total: 0,
  }),

  created() {
    this.fetchData(this.currentPage);
  },

  methods: {
    onPageClick(event) {
      this.currentPage = event;
      this.fetchData(this.currentPage);
    },
    async fetchData(pageNumber) {
      let users = await (
        await fetch(`http://localhost/users?page=${pageNumber}`)
      ).json();

      this.data = users.data.list;
      this.currentPage = users.data.paginate?.page;
      this.perPage = users.data.paginate?.perPage;
      this.total = users.data.paginate?.total;
    },
  },
};
</script>