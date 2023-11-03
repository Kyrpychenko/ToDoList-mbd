<script lang="ts">
export const filter = 'none';
</script>
<template>
    <div class="h-100 position-sticky top-0 ms-2 bg-light" style="width: 240px; z-index: -1">
        <ul class="list-unstyled">
            <li>Text goes here</li>
        </ul>
    </div>
</template>

<style scoped>
.left-menu ul {
    list-style: none;
    padding: 0;
}

.left-menu li {
    cursor: pointer;
    margin-bottom: 10px;
    padding: 10px;
}

.left-menu li:hover {
    text-decoration: underline;
}
</style>
