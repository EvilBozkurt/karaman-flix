<template>
  <app-layout>
    <template #header>
      <Breadcrumbs :items="breadcrumbs" />
    </template>

    <Container>
      <jet-button :href="route('movies.create')">Add new</jet-button>

      <Card class="mt-4">
        <AppTable :headers="headers"
                  :items="movies">
          <tr v-for="movie in movies.data"
              :key="movie.id">
            <td>{{ movie.title }}</td>
            <td>{{ movie.category.name }}</td>
            <td>{{ movie.created_at_for_human }}</td>
            <td>
              <div class="flex items-center justify-end space-x-2">
                <EditBtn :url="route('movies.edit', {movie: movie.id})" />
                <DeleteBtn :url="route('movies.destroy', {movie: movie.id})"
                           module-name="movie" />
              </div>
            </td>
          </tr>
        </AppTable>
      </Card>
    </Container>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import EditBtn from "@/Components/EditBtn";
import DeleteBtn from "@/Components/DeleteBtn";
import SimplePagination from "@/Components/SimplePagination";
import AppTable from "@/Components/Table";
import Container from "@/Components/Container";
import Card from "@/Components/Card";
import Breadcrumbs from "@/Components/Breadcrumbs";
import JetButton from "@/Jetstream/Button";

export default {
  props: {
    movies: {},
  },

  components: {
    AppLayout,
    EditBtn,
    DeleteBtn,
    SimplePagination,
    AppTable,
    JetButton,
    Container,
    Card,
    Breadcrumbs,
  },

  computed: {
    headers() {
      return [
        {
          name: "Title",
        },
        {
          name: "Category",
        },
        {
          name: "Created Date",
        },
        {
          name: "Action",
          class: "text-right",
        },
      ];
    },

    breadcrumbs() {
      return [
        {
          label: "Movies",
        },
      ];
    },
  },
};
</script>
