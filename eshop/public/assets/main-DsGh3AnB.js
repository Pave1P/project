import{d as n,c as r,a as c,b as m,M as l}from"./index-DuYTNNAz.js";const o=n("movies",{state:()=>({movies:[],nextTempId:1}),actions:{getSchema(){return{id:0,title:"",category:"",watched:!1}},loadMovies(t){this.movies=t.map(e=>({...this.getSchema(),...e}))},getMovies(){return this.movies},getMovie(t){const e=this.movies.find(s=>s.id===t);return e||null},toggleWatched(t){const e=this.movies.find(s=>s.id===t);e&&(e.watched=!e.watched)},addMovie(t){const e=t.trim();e&&(this.movies.push({...this.getSchema(),id:-this.nextTempId,title:e}),this.nextTempId++)},removeMovie(t){this.movies=this.movies.filter(e=>e.id!==t)},changeCategoryName(t,e){const s=this.movies.find(i=>i.id===t);s&&(s.category=e)}},getters:{totalCount(){return this.movies.length},watchedCount(){return this.movies.filter(t=>t.watched).length},unwatchedCount(){return this.totalCount-this.watchedCount}}});window.useMoviesStore=o;const v={name:"Todo",props:{types:Array,items:Array},data(){return{categories:[],filter:"",moviesStore:null}},created(){this.categories=this.types.map(t=>({...t})),this.moviesStore=o(),this.moviesStore.loadMovies(this.items)},computed:{totalCount(){return this.moviesStore.totalCount},watchedCount(){return this.moviesStore.watchedCount},unwatchedCount(){return this.moviesStore.unwatchedCount},filteredList(){const t=this.moviesStore.getMovies();return this.filter===""?t:this.filter==="watched"?t.filter(e=>e.watched):this.filter==="unwatched"?t.filter(e=>!e.watched):t.filter(e=>e.category===this.filter)}},methods:{getCategoryName(t){return this.categories.find(e=>e.id===t)?.name||"–"},changeCategoryName(t){const e=this.moviesStore.getMovie(t);if(!e)return;const s=(this.categories.findIndex(i=>i.id===e.category)+1)%this.categories.length;this.moviesStore.changeCategoryName(e.id,this.categories[s].id)},toggleWatched(t){this.moviesStore.toggleWatched(t)},addMovie(){const t=prompt("Введите название фильма");this.moviesStore.addMovie(t)},removeMovie(t){this.moviesStore.removeMovie(t)}},template:`
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
    `},d=m({name:"Root",components:{MainLayout:l,Todo:v},data:()=>window.__APP_DATA__,template:`
		<MainLayout>
			<Todo :types="types" :items="items" />
		</MainLayout>
	`}),a=r(d);a.use(c());a.mount("#application");
