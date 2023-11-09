import { TodoItem, TodoList, User } from '@/types';
import { computed, ref } from 'vue';
export const currentUser = ref<User | null>(null);
export const allLists = ref<TodoList[]>([]);
export const filterOptions = ref<'inWork' | 'unstarted' | 'finished' | 'createdBy' | null>(null);
export const sortOptions = ref<'priority' | 'deadline' | null>(null);
export const searchValue = ref('');
export function toggleFilter(option: typeof filterOptions.value) {
    if (filterOptions.value === option) filterOptions.value = null;
    else filterOptions.value = option;
}
export function toggleSort(option: typeof sortOptions.value) {
    if (sortOptions.value === option) sortOptions.value = null;
    else sortOptions.value = option;
}
export const displayedLists = computed(() => {
    return allLists.value
        .map(e => ({
            ...e,
            todo_items: e.todo_items.filter(t =>
                filterOptions.value === null || filterOptions.value === 'finished' || filterOptions.value === 'unstarted'
                    ? t.state === filterOptions.value
                    : filterOptions.value === 'createdBy'
                    ? t.user_id === currentUser.value?.id
                    : t
            ),
        }))
        .map(e => ({
            ...e,
            todo_items: e.todo_items.filter(t => t.title.includes(searchValue.value) || t.description.includes(searchValue.value)),
        }))
        .filter(l => l.todo_items.length !== 0)
        .map(e => ({
            ...e,
            todo_items: e.todo_items.sort((a, b) => sortFunction(a, b)),
        }));
});
console.log({ displayedLists: displayedLists.value });

export const displayedTodos = computed(() =>
    allLists.value
        .flatMap(e => e.todo_items.filter(t => filterOptions.value === null || t.state === filterOptions.value))
        .sort((a, b) => sortFunction(a, b))
);

function sortFunction(a: TodoItem, b: TodoItem) {
    return sortOptions.value === 'deadline' ? (a.deadline < b.deadline ? 1 : -1) : sortOptions.value === 'priority' ? b.priority - a.priority : 0;
}

export function search(searchValue: string) {
    allLists.value.map(e => ({
        ...e,
        todo_items: e.todo_items.filter(t => t.title.includes(searchValue) || t.description.includes(searchValue)),
    }));
}
