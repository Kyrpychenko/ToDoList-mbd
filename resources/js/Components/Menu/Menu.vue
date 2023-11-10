<script setup lang="ts">
import { filterOptions, sortOptions, toggleFilter, toggleSort, searchValue } from '@/Components/Menu/menu';
import Search from 'custom-mbd-components/src/components/SexyInputs/Search.vue';
</script>
<template>
    <div class="d-flex justify-content-center align-items-center sticky-top">
        <div class="d-flex justify-content-between align-items-center w-100">
            <Search v-model="searchValue" :placeholder="'Suche'"></Search>
            <div class="mt-3">
                <span class="me-2">Filter:</span>
                <!-- <button class="badge rounded-pill bg-secondary text-white me-1" @click="toggleFilter('inWork')">
                        in Arbeit
                        <i v-if="filterOptions !== 'inWork'" class="bi bi-plus-circle"></i>
                        <i v-else class="bi bi-dash-circle"></i>
                    </button> -->
                <div class="btn-group" role="group">
                    <button class="btn btn-secondary text-white me-1" @click="toggleFilter('unfinished')">
                        Nicht Angefangen
                        <i v-if="filterOptions !== 'unfinished'" class="bi bi-plus-circle"></i>
                        <i v-else class="bi bi-dash-circle"></i>
                    </button>
                    <button class="btn btn-secondary text-white me-1" @click="toggleFilter('finished')">
                        Abgeschlossen
                        <i v-if="filterOptions !== 'finished'" class="bi bi-plus-circle"></i>
                        <i v-else class="bi bi-dash-circle"></i>
                    </button>
                    <button class="btn btn-secondary text-white me-1" @click="toggleFilter('createdBy')">
                        Von dir erstellt
                        <i v-if="filterOptions !== 'createdBy'" class="bi bi-plus-circle"></i>
                        <i v-else class="bi bi-dash-circle"></i>
                    </button>
                </div>
                <span class="me-2">Sortieren:</span>
                <div class="btn-group" role="group">
                    <button class="btn btn-secondary text-white me-1" @click="toggleSort('priority')">
                        Priorität
                        <i v-if="sortOptions !== 'priority'" class="bi bi-plus-circle"></i>
                        <i v-else class="bi bi-dash-circle"></i>
                    </button>
                    <button class="btn btn-secondary text-white me-1" @click="toggleSort('deadline')">
                        Deadline
                        <i v-if="sortOptions !== 'deadline'" class="bi bi-plus-circle"></i>
                        <i v-else class="bi bi-dash-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
