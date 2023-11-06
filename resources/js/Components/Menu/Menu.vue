<script setup lang="ts">
import { filterOptions } from '@/Components/Menu/menu';
</script>
<template>
    <div class="d-flex sticky-top" style="height: 0">
        <div>
            <div>Filtern nach:</div>
            <button
                class="badge rounded-pill bg-secondary text-white me-1"
                @click="
                    filterOptions.inWork = !filterOptions.inWork;
                    filterOptions.unstarted = false;
                "
            >
                in Arbeit
                <i v-if="filterOptions.inWork === false" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
            <button
                class="badge rounded-pill bg-secondary text-white me-1"
                @click="
                    filterOptions.unstarted = !filterOptions.unstarted;
                    filterOptions.inWork = false;
                "
            >
                Nicht Angefangen
                <i v-if="filterOptions.unstarted === false" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
            <div>Sortieren nach:</div>
            <button class="badge rounded-pill bg-secondary text-white me-1" @click="filterOptions.priority = !filterOptions.priority">
                Priorität
                <i v-if="filterOptions.priority === false" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
            <button class="badge rounded-pill bg-secondary text-white me-1" @click="filterOptions.deadline = !filterOptions.deadline">
                Deadline
                <i v-if="filterOptions.deadline === false" class="bi bi-plus-circle"></i>
                <i v-else class="bi bi-dash-circle"></i>
            </button>
        </div>
    </div>
</template>

<style scoped></style>
