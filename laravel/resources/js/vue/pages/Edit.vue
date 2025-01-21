<template>
  <div class="min-h-screen bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-bold mb-4">Редактирование</h2>
      <form @submit.prevent="saveChanges">
        <!-- Title -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Title</label>
          <input
            type="text"
            v-model="editedShip.title"
            class="w-full border rounded px-4 py-2"
            placeholder="Enter ship title"
          />
        </div>

        <!-- Description -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Description</label>
          <textarea
            v-model="editedShip.description"
            class="w-full border rounded px-4 py-2 h-32"
            placeholder="Enter ship description"
          ></textarea>
        </div>

        <!-- Specifications -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Specifications</label>
          <div
            v-for="(spec, index) in editedShip.spec"
            :key="index"
            class="flex items-center space-x-2 mb-2"
          >
            <input
              v-model="spec.name"
              placeholder="Spec name"
              class="flex-1 border rounded px-2 py-1"
            />
            <input
              v-model="spec.value"
              placeholder="Spec value"
              class="flex-1 border rounded px-2 py-1"
            />
            <button
              type="button"
              @click="removeSpec(index)"
              class="text-red-500 hover:underline"
            >
              Удалить
            </button>
          </div>
          <button
            type="button"
            @click="addSpec"
            class="mt-2 text-indigo-600 hover:underline"
          >
            Add Specification
          </button>
        </div>

        <!-- Cabin Categories -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Cabin Categories</label>
          <div
            v-for="(cabin, index) in editedShip.cabin_categories"
            :key="cabin.id || index"
            class="flex items-center space-x-2 mb-2"
          >
            <input
              v-model="cabin.title"
              placeholder="Cabin Category Title"
              class="flex-1 border rounded px-2 py-1"
            />
            <input
              v-model="cabin.vendor_code"
              placeholder="Cabin Category Vendor Code"
              class="flex-1 border rounded px-2 py-1"
            />
            <input
              v-model="cabin.description"
              placeholder="Cabin Category Description"
              class="flex-1 border rounded px-2 py-1"
            />
            <button
              type="button"
              @click="removeCabinCategory(index)"
              class="text-red-500 hover:underline"
            >
              Удалить
            </button>
          </div>
          <button
            type="button"
            @click="addCabinCategory"
            class="mt-2 text-indigo-600 hover:underline"
          >
            Add Cabin Category
          </button>
        </div>

        <!-- Gallery -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Gallery</label>
          <div class="grid grid-cols-3 gap-4">
            <div
              v-for="(image, index) in editedShip.ships_gallery"
              :key="image.id"
              class="relative"
            >
              <img
                :src="image.url"
                alt="Gallery Image"
                class="w-full h-32 object-cover rounded border"
              />
              <p class="text-center mt-2 text-gray-600">{{ image.title }}</p>
              <button
                type="button"
                @click="removeGallery(index)"
                class="absolute top-1 right-1 bg-red-500 text-white text-sm px-2 py-1 rounded"
              >
                ✕
              </button>
            </div>
            <!-- Add New Image -->
            <div class="flex flex-col items-center justify-center h-48 border rounded">
              <input
                type="text"
                v-model="newGalleryTitle"
                placeholder="Enter image title"
                class="w-full border rounded px-2 py-1 mb-2"
              />
              <input
                type="text"
                v-model="newGalleryImage"
                placeholder="Enter image URL"
                class="w-full border rounded px-2 py-1 mb-2"
              />
              <button
                type="button"
                @click="addGallery"
                class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600"
              >
                Add Image
              </button>
            </div>
          </div>
        </div>

        <!-- Save, Cancel Buttons -->
        <div class="py-4">
          <a
            @click="saveShip"
            ref="buttonSubmit"
            type="button"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
          >
            Save
          </a>
          <router-link
            :to="'/'"
            class="bg-indigo-500 text-white px-4 py-2 mx-2 rounded hover:bg-indigo-600"
          >
            Cancel
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  data() {
    return {
      editedShip: { cabin_categories: [], ships_gallery: [], spec: [] },
      newGalleryImage: "", // For adding new gallery images
      newGalleryTitle: "", // For adding new gallery titles
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    saveShip() {
      if (this.editedShip.title) {
        console.log(this.editedShip);
        this.$refs.buttonSubmit.disabled = true;
        this.updateShip();
        location.href = '/';
      } else {
        alert("Title is required");
        return false;
      }
    },
    addSpec() {
      this.editedShip.spec.push({ name: "", value: "" });
    },
    removeSpec(index) {
      this.editedShip.spec.splice(index, 1);
    },
    addCabinCategory() {
      this.editedShip.cabin_categories.push({ 
        id: 0, 
        ship_id: 
        this.editedShip.id, 
        title: "",  
        vendor_code: ""
      });
    },
    async removeCabinCategory(index) {
      const cabinCategoriesItem = this.editedShip.cabin_categories[index];
      this.editedShip.cabin_categories.splice(index, 1);
      if (cabinCategoriesItem.id && confirm("This will permanently delete the Cabin Categorie. Proceed?")) {
        try {
          await axios.delete(`/api/cabincategories/${cabinCategoriesItem.id}`);
        } catch (error) {
          console.error("Error deleting cabincategories:", error);
        }
      }
    },
    addGallery() {
      if (this.newGalleryImage && this.newGalleryTitle) {
        this.editedShip.ships_gallery.push({
          id: 0,
          ship_id: this.editedShip.id,
          url: this.newGalleryImage,
          title: this.newGalleryTitle,
        });
        this.newGalleryImage = ""; // Clear input after adding
        this.newGalleryTitle = ""; // Clear input after adding
      } else {
        alert("Please enter a valid image title and URL.");
      }
    },
    async removeGallery(index) {
      const galleryItem = this.editedShip.ships_gallery[index];
      this.editedShip.ships_gallery.splice(index, 1);
      if (galleryItem.id && confirm("This will permanently delete the image. Proceed?")) {
        try {
          await axios.delete(`/api/shipsgallery/${galleryItem.id}`);
        } catch (error) {
          console.error("Error deleting shipsgallery:", error);
        }
      }
    },
    async updateShip() {
      try {
        this.editedShip.cabinCategories = this.editedShip.cabin_categories;
        this.editedShip.shipsGallery = this.editedShip.ships_gallery;
        const response = await axios.put(
          `/api/ships/${this.editedShip.id}`,
          this.editedShip
        );
        console.log("Updated ship:", response.data);
      } catch (error) {
        console.error("Error updating ship:", error);
      }
    },
    async fetchData() {
      const id = this.$route.params.id;
      try {
        const response = await axios.get(`/api/ships/${id}`);
        this.editedShip = response.data.ship;
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
  },
};
</script>
