<template>

     <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-500">Список лайнеров</h1>
        <div class=" flex  p-4">
            <router-link
            :to="'/edit/0'"
            class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600"
            >
              Создать новый
            </router-link>
        </div>
        <div v-if="loading" class="text-center">
            <p class="text-gray-500">Loading ships...</p>
        </div>

        <div v-else-if="ships.length > 0">


          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4">

            <div v-for="(ship, key) in ships" class="bg-white rounded-lg shadow-lg overflow-hidden">
              <img v-if="ship.ships_gallery[0]" :src="ship.ships_gallery[0].url" alt="ship image" class="w-full h-48 object-cover" />
              <div class="p-4">
                <h2 class="text-xl font-bold mb-2">
                  {{ ship.title }}
                  <span
                        class="px-2 py-1 mx-4 rounded-full text-xs font-medium"
                        :class="ship.state ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                    >
                        {{ ship.state ? 'В продаже' : 'Не продается' }}
                    </span>
                </h2>
                <p class="text-gray-600 mb-4 cut-text" v-html="ship.description"></p>
                <p class="text-lg font-semibold text-indigo-600 mb-4 ">{{ ship.price }}</p>
                <ul class="mb-4">
                  <li class="text-gray-700 text-sm mb-1 " v-for="(item, key) in ship.spec">{{item.name}}: {{item.value}}</li>
                </ul>
                <div class="py-4">
                  <router-link
                    :to="'/edit/' + ship.id"
                    class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600"
                  >
                    Редактировать
                  </router-link>
                  <a class="bg-red-500 text-white px-4 py-2 mx-2 rounded hover:bg-red-600"
                  @click="deleteItem(ship.id)"
                  >
                    Удалить
                  </a>
                </div>
              </div>
            </div>
         </div>

        </div>
        <div v-else class="text-center">
            <p class="text-gray-500">No ships available.</p>
        </div>
    </div>

</template>

<script>
import axios from 'axios';

export default {
  name: "App",
  data() {
      return {
          ships: [],
      };
  },
  mounted() {
      this.fetchData();
  },
  methods: {
      async deleteItem(id){
        if(confirm('Удалить?')){
          try {
              const response = await axios.delete('/api/ships/' + id);
              this.fetchData();
              console.log(response.data);
          } catch (error) {
              console.error('Error fetching data:', error);
          }
        } else {
          return false;
        }
      },
      async fetchData() {
          try {
              const response = await axios.get('/api/ships');
              this.ships = response.data.ships;
              console.log(response.data.ships);
          } catch (error) {
              console.error('Error fetching data:', error);
          }
      },
  },
};
</script>

<style scoped>

.cut-text, .cut-text p {
  display: -webkit-box;       
  -webkit-box-orient: vertical; 
  -webkit-line-clamp: 4;      
  overflow: hidden;            
}

</style>
