import{o as u,j as w,r as _,x as k,m as B,E as $,g as C,c as D,a,w as r,f,A as p,b as e,D as y,n as v,l as S,G as E,s as x,T as V,u as c,I as A,d as g}from"./app-ece2a1fe.js";import{_ as T}from"./_plugin-vue_export-helper-c27b6911.js";import{_ as U,a as N,b as P}from"./TextInput-d59d0aae.js";import{S as z}from"./sweetalert2.all-2d76b64b.js";const I={},K={class:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"};function M(s,n){return u(),w("button",K,[_(s.$slots,"default")])}const O=T(I,[["render",M]]),W={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},j=e("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1),F=[j],L={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(s,{emit:n}){const o=s;k(()=>o.show,()=>{o.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const t=()=>{o.closeable&&n("close")},i=l=>{l.key==="Escape"&&o.show&&t()};B(()=>document.addEventListener("keydown",i)),$(()=>{document.removeEventListener("keydown",i),document.body.style.overflow=null});const d=C(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[o.maxWidth]);return(l,m)=>(u(),D(E,{to:"body"},[a(y,{"leave-active-class":"duration-200"},{default:r(()=>[f(e("div",W,[a(y,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:r(()=>[f(e("div",{class:"fixed inset-0 transform transition-all",onClick:t},F,512),[[p,s.show]])]),_:1}),a(y,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:r(()=>[f(e("div",{class:v(["mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",d.value])},[s.show?_(l.$slots,"default",{key:0}):S("",!0)],2),[[p,s.show]])]),_:3})],512),[[p,s.show]])]),_:3})]))}},Y=["type"],q={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup(s){return(n,o)=>(u(),w("button",{type:s.type,class:"inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"},[_(n.$slots,"default")],8,Y))}},G={class:"space-y-6"},H=e("header",null,[e("h2",{class:"text-lg font-medium text-gray-900"},"Delete Account"),e("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ")],-1),J={class:"p-6"},Q=e("h2",{class:"text-lg font-medium text-gray-900"}," Are you sure you want to delete your account? ",-1),R=e("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. ",-1),X={class:"mt-6"},Z={class:"mt-6 flex justify-end"},ae={__name:"DeleteUserForm",setup(s){const n=x(!1),o=x(null),t=V({password:""}),i=async()=>{await z.fire({title:"Yakin ingin menghapus?",icon:"question",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"No, cancel!",cancelButtonColor:"#d33",reverseButtons:!0,input:"password",inputPlaceholder:"Enter your password",inputAttributes:{autocapitalize:"off",autocorrect:"off"}}).then(m=>{m.isConfirmed})},d=()=>{t.delete(route("profile.destroy"),{preserveScroll:!0,onSuccess:()=>l(),onError:()=>o.value.focus(),onFinish:()=>t.reset()})},l=()=>{n.value=!1,t.reset()};return(m,h)=>(u(),w("section",G,[H,e("button",{type:"button",onClick:i,class:"btn btn-danger me-1 mb-1"},"Delete Account"),a(L,{show:n.value,onClose:l},{default:r(()=>[e("div",J,[Q,R,e("div",X,[a(U,{for:"password",value:"Password",class:"sr-only"}),a(N,{id:"password",ref_key:"passwordInput",ref:o,modelValue:c(t).password,"onUpdate:modelValue":h[0]||(h[0]=b=>c(t).password=b),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:A(d,["enter"])},null,8,["modelValue","onKeyup"]),a(P,{message:c(t).errors.password,class:"mt-2"},null,8,["message"])]),e("div",Z,[a(q,{onClick:l},{default:r(()=>[g(" Cancel ")]),_:1}),a(O,{class:v(["ml-3",{"opacity-25":c(t).processing}]),disabled:c(t).processing,onClick:d},{default:r(()=>[g(" Delete Account ")]),_:1},8,["class","disabled"])])])]),_:1},8,["show"])]))}};export{ae as default};
