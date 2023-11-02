<script lang="ts">
export const filter = 'none';
</script>
<template>
    <div class="left-menu position-absolute top-10 h-100 bg-light text-dark" style="width: 240px; padding: 10px">
        <ul>
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
}

.left-menu li:hover {
    text-decoration: underline;
}
</style>
