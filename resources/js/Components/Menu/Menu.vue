<script setup lang="ts">
import { filterOptions, sortOptions, toggleFilter, toggleSort } from '@/Components/Menu/menu';
</script>
<template>
    <div class="d-flex sticky-top" style="height: 0">
        <div>
            <div>Filtern nach:</div>
            <button class="badge rounded-pill bg-secondary text-white me-1" @click="toggleFilter('inWork')">
                in Arbeit
                <i v-if="filterOptions !== 'inWork'" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
            <button class="badge rounded-pill bg-secondary text-white me-1" @click="toggleFilter('unstarted')">
                Nicht Angefangen
                <i v-if="filterOptions !== 'unstarted'" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
            <button class="badge rounded-pill bg-secondary text-white me-1" @click="toggleFilter('finished')">
                Abgeschlossen
                <i v-if="filterOptions !== 'finished'" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
            <div>Sortieren nach:</div>
            <button class="badge rounded-pill bg-secondary text-white me-1" @click="toggleSort('priority')">
                Priorität
                <i v-if="sortOptions !== 'priority'" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
            <button class="badge rounded-pill bg-secondary text-white me-1" @click="toggleSort('deadline')">
                Deadline
                <i v-if="sortOptions !== 'deadline'" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
        </div>
    </div>
</template>

<style scoped></style>
