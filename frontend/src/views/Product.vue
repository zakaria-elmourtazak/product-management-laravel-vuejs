<script setup>
import axios from "../axios";
import moment from "moment";
</script>

<template>
  <div class="container mt-3">
    <div v-if="productSaved" class="alert alert-success" role="alert">
      the Product is added succesfuly
    </div>
    <div v-if="productUpdated" class="alert alert-warning" role="alert">
      the Product is updated succesfuly
    </div>
    <div v-if="productDeleted" class="alert alert-success" role="alert">
      the Product is deleted succesfuly
    </div>

    <!-- form modal  -->
    <div
      class="modal fade"
      ref="productForm"
      id="productForm"
      tabindex="-1"
      aria-labelledby="productForm"
      aria-hidden="false"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fs-5">
              {{
                this.modalFormType == "CREATE"
                  ? "Create Product"
                  : "Edit Product"
              }}
            </h5>

            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            <div v-if="this.errorList" class="">
              <ul
                class="alert alert-danger"
                role="alert"
                v-if="Object.keys(this.errorList).length > 0"
              >
                <li v-for="(error, field) in errorList" :key="field">
                  {{ error[0] }}
                </li>
              </ul>
            </div>
            <form>
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                  v-model="model.product.name"
                  type="text"
                  class="form-control"
                  id="name"
                  aria-describedby="emailHelp"
                />
              </div>
              <div class="mb-3">
                <label for="slug" class="form-label">slug</label>
                <input
                  v-model="model.product.slug"
                  type="text"
                  class="form-control"
                  id="slug"
                />
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea
                  v-model="model.product.description"
                  class="form-control"
                  id="description"
                />
              </div>
              <div class="mb-3">
                <label for="type" class="form-label">type</label>
                <input
                  v-model="model.product.type"
                  type="text"
                  class="form-control"
                  id="type"
                />
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input
                  v-model="model.product.price"
                  type="number"
                  class="form-control"
                  id="price"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button
              @click="
                () => {
                  this.modalFormType == 'CREATE'
                    ? saveProduct()
                    : updateProduct();
                }
              "
              type="button"
              class="btn btn-primary"
            >
              {{ this.modalFormType == "CREATE" ? "Create" : "Save" }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- delete modal  -->
    <div
      class="modal fade"
      id="deleteModal"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">
              Delete Confirmation
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this item?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary px-3"
              data-bs-dismiss="modal"
            >
              No
            </button>
            <button
              @click="this.deleteProduct"
              type="button"
              class="btn btn-danger px-3"
            >
              Yes
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h2 class="p-2">Produts</h2>
        <div class="d-flex">
          <!-- <form class="d-flex" role="search"> -->
          <input
            class="form-control"
            v-model="searchText"
            type="search"
            :placeholder="searchBy"
            aria-label="Search"
          />
          <div class="dropdown mx-2">
            <button
              class="btn btn-secondary dropdown-toggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              search by
            </button>
            <ul class="dropdown-menu">
              <li>
                <a
                  @click="
                    () => {
                      searchBy = 'Search by name';
                    }
                  "
                  class="dropdown-item"
                  >name</a
                >
              </li>
              <li>
                <a
                  @click="
                    () => {
                      searchBy = 'Search by slug';
                    }
                  "
                  class="dropdown-item"
                  >slug</a
                >
              </li>
              <li>
                <a
                  @click="
                    () => {
                      searchBy = 'Search by type';
                    }
                  "
                  class="dropdown-item"
                  >type</a
                >
              </li>
              <li>
                <a
                  @click="
                    () => {
                      searchBy = 'Search by price';
                    }
                  "
                  class="dropdown-item"
                  >price</a
                >
              </li>
            </ul>
          </div>
          <button
            class="btn btn-outline-success"
            type="button"
            @click="getProducts"
          >
            Search
          </button>
          <button
            type="button"
            class="btn btn-primary float-end ms-2 px-4"
            data-bs-toggle="modal"
            data-bs-target="#productForm"
            @click="
              () => {
                this.initForm();
                this.modalFormType = 'CREATE';
              }
            "
          >
            New
          </button>
        </div>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Slug</th>
              <th scope="col">Description</th>
              <th scope="col">Type</th>
              <th scope="col">Price</th>
              <th scope="col">Created at</th>
              <th scope="col">Actoin</th>
            </tr>
          </thead>
          <tbody v-if="this.products.length > 0">
            <tr v-for="(product, index) in this.products" :key="index">
              <td scope="row">{{ product.id }}</td>
              <td>{{ product.name }}</td>
              <td>{{ product.slug.substring(0, 10) + "..." }}</td>
              <td>{{ product.description.substring(0, 10) + "..." }}</td>
              <td>{{ product.type }}</td>
              <td>{{ product.price }}</td>
              <td>{{ formatDate(product.created_at) }}</td>
              <td>
                <button
                  type="button"
                  class="btn btn-warning"
                  data-bs-toggle="modal"
                  data-bs-target="#productForm"
                  @click="
                    () => {
                      this.initForm();
                      this.findProductById(product.id);
                      this.modalFormType = 'EDIT';
                    }
                  "
                >
                  Edit
                </button>
                <button
                  type="button"
                  class="btn btn-danger ms-2"
                  data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  @click="
                    () => {
                      this.findProductById(product.id);
                    }
                  "
                >
                  Delete
                </button>
              </td>
            </tr>
            <!-- Pagination -->
          </tbody>

          <tbody v-if="totalElements == 0 && !loading">
            <div
              class="alert alert-danger text-center mt-4 ms-auto flaot-center"
              role="alert"
            >
              Stock Empty: No Products Available
            </div>
          </tbody>

          <tbody v-if="loading">
            <div class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </tbody>
        </table>
        <div class="card-footer">
          <nav>
            <ul class="pagination">
              <li
                class="page-item"
                :class="{ disabled: !(this.currentPage > 1) }"
              >
                <a class="page-link" @click="previousPage"> Previous </a>
              </li>
              <li
                class="page-item"
                :class="{ active: page === currentPage }"
                v-for="page in totalPages"
                :key="page"
              >
                <a class="page-link" @click="gotoPage(page)">{{ page }}</a>
              </li>
              <li
                class="page-item"
                :class="{ disabled: !(this.currentPage < totalPages) }"
              >
                <a class="page-link" href="#" @click="nextPage"> Next </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "products",
  data() {
    return {
      searchBy: "name",
      modalFromType: "CREATE",
      productUpdated: false,
      productSaved: false,
      productDeleted: false,
      errorList: null,
      searchText: "",
      products: [],
      currentPage: 1,
      perPage: 5,
      totalElements: 0,
      loading: false,
      model: {
        product: {
          id: "",
          name: "",
          slug: "",
          description: "",
          type: "",
          price: 0,
        },
      },
    };
  },
  mounted() {
    this.getProducts();
  },
  computed: {
    totalPages() {
      return Math.ceil(this.totalElements / this.perPage);
    },

    paginatedProducts() {
      const startIndex = (this.currentPage - 1) * this.perPage;
      const endIndex = startIndex + this.perPage;
      return this.products.slice(startIndex, endIndex);
    },
  },
  methods: {
    formatDate(date) {
      return moment(date).format("YYYY-MM-DD HH:mm:ss");
    },
    gotoPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.getProducts();
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.getProducts();
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.getProducts();
      }
    },
    deleteProduct() {
      axios
        .delete(`/products/${this.model.product.id}`)
        .then((response) => {
          console.log(response.data);
          this.productDeleted = true;
          this.getProducts();
          // Close the delete modal
        })
        .catch((error) => {
          console.error(error);
        });
    },

    initForm() {
      (this.model.product = {
        id: "",
        name: "",
        slug: "",
        description: "",
        price: 0,
      }),
        (this.errorList = null);
    },
    updateProduct() {
      axios
        .put(`/products/${this.model.product.id}`, this.model.product, {
          withCredentials: true,
        })
        .then((response) => {
          // Handle successful update
          this.productUpdated = true;
          console.log(response.data);
          this.getProducts();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errorList = error.response.data.errors;
          }
          if (error.request) {
            console.log(error.request);
          }

          if (error.message) {
            console.log("Error", error.message);
          }
        });
    },
    findProductById(id) {
      axios.get(`/products/${id}`).then((res) => {
        this.model.product = res.data;
        console.log(this.model.product);
      });
    },
    saveProduct() {
      console.log(this.model.product);
      axios
        .post("/products", this.model.product)
        .then((res) => {
          console.log(res.data);
          this.productSaved = true;
          this.getProducts();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errorList = error.response.data.errors;
          }
          if (error.request) {
            console.log(error.request);
          }

          if (error.message) {
            console.log("Error", error.message);
          }
        });
    },

    getProducts() {
      this.loading = true;
      if (this.searchBy.startsWith("Search by")) {
        this.searchBy = this.searchBy.slice("search by".length);
      }
      axios
        .get(
          `/products?per_page=${this.perPage}&page=${this.currentPage}&query=${this.searchText}&searchby=${this.searchBy}`
        )
        .then((res) => {
          this.products = res.data.data;
          this.totalElements = res.data.pagination.total;
          console.log(this.products);
          this.searchText = "";
          this.productSaved = false;
          this.productUpdated = false;
          this.productDeleted = false;
          this.loading = false;
        });
    },
  },
};
</script>
