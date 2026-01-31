import {useMoviesStore} from "@model/moviesStore.js";

export const Todo = {
    name: 'Todo',

    props: {
        types: Array,
        items: Array,
    },

    data() {
        return {
            categories: [],
            filter: '',
            moviesStore: null,
        }
    },

    created()
    {
        this.categories = this.types.map(category => ({ ...category }));

        this.moviesStore = useMoviesStore();
        this.moviesStore.loadMovies(this.items);
    },

    computed:
    {
        totalCount()
        {
            return this.moviesStore.totalCount;
        },

        watchedCount()
        {
            return this.moviesStore.watchedCount;
        },

        unwatchedCount()
        {
            return this.moviesStore.unwatchedCount;
        },

        filteredList()
        {
            const movies = this.moviesStore.getMovies();

            if (this.filter === '')
            {
                return movies;
            }

            if (this.filter === 'watched')
            {
                return movies.filter(movie => movie.watched);
            }

            if (this.filter === 'unwatched')
            {
                return movies.filter(movie => !movie.watched);
            }

            return movies.filter(movie => movie.category === this.filter);
        }
    },

    methods:
    {
        getCategoryName(id)
        {
            return this.categories.find(type => type.id === id)?.name || '–';
        },

        changeCategoryName(id)
        {
            const movie = this.moviesStore.getMovie(id);
            if (!movie)
            {
                return;
            }

            const nextCategoryId = (
                this.categories.findIndex( type => type.id === movie.category ) + 1
            )
            % this.categories.length;

            this.moviesStore.changeCategoryName(movie.id, this.categories[nextCategoryId].id)
        },

        toggleWatched(id)
        {
            this.moviesStore.toggleWatched(id);
        },

        addMovie()
        {
            const title = prompt('Введите название фильма');
            this.moviesStore.addMovie(title);
        },

        removeMovie(id)
        {
            this.moviesStore.removeMovie(id);
        },
    },

    template: `
         <section class="movies">
            <!-- Тулбар -->
            <div class="movies__toolbar">
                <div class="movies__filters">
                    <button :class="['chips', { '--active': !filter }]" @click="filter = ''">Все</button>
                    <span class="movies__stats-separator"></span>
                    <button 
                        v-for="type in categories"
                        :key="type.id"
                        :class="['chips', { '--active': filter === type.id }]" 
                        @click="filter = type.id"
                    >
                        {{ type.name }}
                    </button>
                    <span class="movies__stats-separator"></span>
                    <button class="chips" :class="{ '--active': filter === 'watched' }" @click="filter = 'watched'">Просмотренные</button>
                    <button class="chips" :class="{ '--active': filter === 'unwatched' }" @click="filter = 'unwatched'">Непросмотренные</button>
                    <span class="movies__stats-separator"></span>
                    <button class="chips --new" @click="addMovie">Добавить фильм</button>
                </div>
                <div class="movies__stats">
                    <span>Всего: <strong class="movies__stats-counter">{{ totalCount }}</strong></span>
                    <span class="movies__stats-separator"></span>
                    <span>Просмотрено: <strong class="movies__stats-counter">{{ watchedCount }}</strong></span>
                    <span class="movies__stats-separator"></span>
                    <span>Осталось: <strong class="movies__stats-counter">{{ unwatchedCount }}</strong></span>
                </div>
            </div>
        
            
            <div v-if="!filteredList.length" class="movies-list" >
                <p class="movies-list__item">Нет фильмов для выбранного фильтра</p>
            </div>
           
            <ul v-else class="movies-list">
                <li
                    v-for="movie in filteredList"
                    :key="movie.id"
                    :class="['movies-list__item', { '--watched' : movie.watched }]"
                >
                    <div class="movies-list__main">
                        <span 
                            :class="['badge', '--' + movie.category]"
                            @click="changeCategoryName(movie.id)"
                        >
                            {{ getCategoryName(movie.category) }}
                        </span>
                        <span class="movies-list__title">{{ movie.title }}</span>
                    </div>
                    <div class="movies-list__actions">
                        <button class="button --action" @click="toggleWatched(movie.id)">
                            {{ movie.watched ? '☇ Венуть' : ' ✔ Просмотрено' }}
                        </button>
                        <button class="button --remove" @click="removeMovie(movie.id)">🗑</button>
                    </div>
                </li>
            </ul>
        </section>
    `,
}
