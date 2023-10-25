<template>
    <nav aria-label="...">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
          <a class="page-link" @click.prevent="changePage(1)">First page</a>
        </li>
        <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
          <a
            class="page-link"
            @click.prevent="changePage(pagination.current_page - 1)"
            >Previous</a
          >
        </li>
  
        <li
          class="page-item"
          v-for="page in pages"
          :key="page"
          :class="isCurrentPage(page) ? 'active' : ''"
        >
          <a class="page-link" @click.prevent="changePage(page)"
            >{{ page }}
            <span v-if="isCurrentPage(page)" class="sr-only">(current)</span>
          </a>
        </li>
  
        <li
          class="page-item"
          :class="{ disabled: pagination.current_page >= pagination.last_page }"
        >
          <a
            class="page-link"
            @click.prevent="changePage(pagination.current_page + 1)"
            >Next</a
          >
        </li>
        <li
          class="page-item"
          :class="{ disabled: pagination.current_page >= pagination.last_page }"
        >
          <a class="page-link" @click.prevent="changePage(pagination.last_page)"
            >Last page</a
          >
        </li>
      </ul>
    </nav>
  </template>
  
  <script setup>
  import { computed } from "vue";
  const props = defineProps(["pagination", "offset"]);
  
  
  const isCurrentPage = (page) => {
    return props.pagination.current_page === page;
  };
  const emit = defineEmits(["paginate"]);
  const changePage = (page) => {
    if (page > props.pagination.last_page) {
      page = props.pagination.last_page;
    }
    props.pagination.current_page = page;
    console.log('hello',page);
    emit("paginate", page);
  };
  
  const pages = computed(() => {
    let pages = [];
    let from = props.pagination.current_page - Math.floor(props.offset / 2);
    if (from < 1) {
      from = 1;
    }
    let to = from + props.offset - 1;
    if (to > props.pagination.last_page) {
      to = props.pagination.last_page;
    }
    while (from <= to) {
      pages.push(from);
      from++;
    }
    return pages;
  });
  </script>
  