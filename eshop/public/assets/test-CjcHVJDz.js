import{c as s,b as e,a as i,M as o}from"./index-DuYTNNAz.js";async function r(){return(await fetch("/api/ping")).json()}async function l(t){return(await fetch("/api/echo",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(t)})).json()}async function c(t){return(await fetch("/api/randomizer",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(t)})).json()}const u={name:"Test",data(){return{loading:!1,lastAction:"",result:null,error:null}},methods:{async onPing(){this.loading=!0,this.lastAction="ping",this.result=null,this.error=null;try{const t=await r();this.result=t}catch(t){this.error=t?.message||String(t)}finally{this.loading=!1}},async onRandomizer(){this.loading=!0,this.lastAction="randomizer",this.result=null,this.error=null;try{const t=await c();this.result=t}catch(t){this.error=t?.message||String(t)}finally{this.loading=!1}},onEcho:async function(){this.loading=!0,this.lastAction="echo",this.result=null,this.error=null;try{const t={text:"Hello from frontend",time:Date.now()},n=await l(t);this.result=n}catch(t){this.error=t?.message||String(t)}finally{this.loading=!1}}},template:`
    <main class="debug">
      <h2>Test application</h2>

      <div class="debug__actions">
        <button
          class="debug__button"
          type="button"
          @click="onPing"
          :disabled="loading"
        >
          Test (ping)
        </button>

        <button
          class="debug__button"
          type="button"
          @click="onEcho"
          :disabled="loading"
        >
          Echo
        </button>
      </div>

      <p v-if="loading" class="debug__status">Loading… ({{ lastAction }})</p>
      <pre v-if="result" class="debug__result">{{ JSON.stringify(result, null, 2) }}</pre>
      <pre v-if="error" class="debug__error">{{ error }}</pre>
    </main>
  `},d=e({name:"Root",components:{MainLayout:o,Test:u},data:()=>window.__APP_DATA__,template:`
		<MainLayout>
			<Test/>
		</MainLayout>
	`}),a=s(d);a.use(i());a.mount("#application");
