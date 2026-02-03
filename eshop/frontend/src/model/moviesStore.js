import { defineStore } from 'pinia';

const useMoviesStore = defineStore('movies', {
    state: () => ({
        movies: [],
        nextTempId: 1,
    }),

    actions:
    {
        getSchema()
        {
            return {
                id: 0,
                title: '',
                category: '',
                watched: false,
            }
        },

        loadMovies(rawMovies)
        {
            this.movies = rawMovies.map(movies => ({
                ...this.getSchema(),
                ...movies
            }))
        },

        getMovies()
        {
            return this.movies;
        },

        getMovie(id)
        {
            const movie = this.movies.find(element => element.id === id);
            if (!movie)
            {
                return null;
            }

            return movie
        },

        toggleWatched(id)
        {
            const movie = this.movies.find(element => element.id === id);
            if (!movie)
            {
                return;
            }

            movie.watched = !movie.watched;
        },

        addMovie(title)
        {
            const trimmed = title.trim();
            if (!trimmed)
            {
                return;
            }

            this.movies.push({
                ...this.getSchema(),
                id: -this.nextTempId,
                title: trimmed,
            });

            this.nextTempId++;
        },

        removeMovie(id)
        {
            this.movies = this.movies.filter(movie => movie.id !== id);
        },

        changeCategoryName(id, newCategoryName)
        {
            const movie = this.movies.find(element => element.id === id);
            if (!movie)
            {
                return;
            }

            movie.category = newCategoryName;
        },
    },

    getters:
    {
        totalCount()
        {
            return this.movies.length;
        },

        watchedCount()
        {
            return this.movies.filter(movie => movie.watched).length;
        },

        unwatchedCount()
        {
            return this.totalCount - this.watchedCount;
        },
    },
});

window.useMoviesStore = useMoviesStore;

export { useMoviesStore };
