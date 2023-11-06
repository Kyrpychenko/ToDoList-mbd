import { TodoList } from '@/types';
import { computed, ref } from 'vue';

export const allLists = ref<TodoList[]>([]);
export const filterOptions = ref({
    inWork: false,
    unstarted: false,
    priority: false,
    deadline: false,
});
export const displayedLists = computed(() =>
    allLists.value
        .map(e => ({
            ...e,
            todo_items: e.todo_items.filter(
                t =>
                    (!filterOptions.value.inWork && !filterOptions.value.unstarted) ||
                    t.state === (filterOptions.value.inWork ? 'unfinished' : 'finished')
            ),
        }))
        .filter(l => l.todo_items.length !== 0)
        .map(e => ({
            ...e,
            todo_items: e.todo_items.sort((a, b) =>
                filterOptions.value.deadline ? (a.deadline < b.deadline ? 1 : -1) : filterOptions.value.priority ? b.priority - a.priority : 0
            ),
        }))
);

export const displayedTodos = computed(() =>
    allLists.value
        .flatMap(e =>
            e.todo_items.filter(
                t =>
                    (!filterOptions.value.inWork && !filterOptions.value.unstarted) ||
                    t.state === (filterOptions.value.inWork ? 'unfinished' : 'finished')
            )
        )
        .sort((a, b) =>
            filterOptions.value.deadline ? (a.deadline < b.deadline ? 1 : -1) : filterOptions.value.priority ? b.priority - a.priority : 0
        )
);
