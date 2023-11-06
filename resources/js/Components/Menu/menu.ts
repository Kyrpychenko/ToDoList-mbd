import { TodoItem, TodoList } from '@/types';
import { computed, ref } from 'vue';

export const allLists = ref<TodoList[]>([]);
export const filterOptions = ref<'inWork' | 'unstarted' | 'finished' | null>(null);
export const sortOptions = ref<'priority' | 'deadline' | null>(null);

export function toggleFilter(option: typeof filterOptions.value) {
    if (filterOptions.value === option) filterOptions.value = null;
    else filterOptions.value = option;
}
export function toggleSort(option: typeof sortOptions.value) {
    if (sortOptions.value === option) sortOptions.value = null;
    else sortOptions.value = option;
}
export const displayedLists = computed(() =>
    allLists.value
        .map(e => ({
            ...e,
            todo_items: e.todo_items.filter(t => !filterOptions === null || t.state === filterOptions.value),
        }))
        .filter(l => l.todo_items.length !== 0)
        .map(e => ({
            ...e,
            todo_items: e.todo_items.sort(sortFunction),
        }))
);

export const displayedTodos = computed(() =>
    allLists.value.flatMap(e => e.todo_items.filter(t => !filterOptions === null || t.state === filterOptions.value)).sort(sortFunction)
);

function sortFunction(a: TodoItem, b: TodoItem) {
    return sortOptions.value === 'deadline' ? (a.deadline < b.deadline ? 1 : -1) : sortOptions.value === 'priority' ? b.priority - a.priority : 0;
}
