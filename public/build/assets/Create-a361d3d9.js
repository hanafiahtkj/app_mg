import{T as _,m as f,j as v,b as e,f as d,v as r,u as o,n as c,t as m,e as k,q as g,H as y,o as w}from"./app-ece2a1fe.js";/* empty css                      *//* empty css                */import{S as x}from"./sweetalert2.all-2d76b64b.js";/* empty css            */import"./app-82ed81c5.js";/* empty css                                                            */const j=["onSubmit"],C={class:"modal fade text-left",id:"inlineForm",tabindex:"-1","aria-labelledby":"myModalLabel33","aria-hidden":"true",style:{display:"none"}},S={class:"modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg",role:"document"},B={class:"modal-content"},F=g('<div class="modal-header"><h4 class="modal-title" id="myModalLabel33">Create</h4><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button></div>',1),L={class:"modal-body"},M=e("h6",null,"Nama Pekerja",-1),E={class:"form-group"},I={class:"invalid-feedback"},T=e("h6",null,"Tanggal Lahir",-1),V={class:"form-group"},D={class:"invalid-feedback"},N=e("h6",null,"Jabatan",-1),P={class:"form-group"},U={class:"invalid-feedback"},q={class:"modal-footer",style:{"background-color":"#f6f8fb"}},z=e("button",{type:"button",class:"btn bg-white btn-outline-default border me-auto","data-bs-dismiss":"modal","aria-label":"Close"},[e("i",{class:"bx bx-x d-block d-sm-none"}),e("span",{class:"d-none d-sm-block"},"Close")],-1),A=["disabled"],H=e("i",{class:"bx bx-check d-block d-sm-none"},null,-1),J=e("span",{class:"d-none d-sm-block"},"Simpan",-1),O=[H,J],ee={__name:"Create",props:{idPkwt:Number,perusahaan:{type:Object},redrawDataTableChild:{type:Function}},setup(u){const p=u,{show:Y,close:G,redirect:h}=y();let i,n;const t=_({id_pkwt:p.idPkwt??"",nama_pekerja:"",tgl_lahir:"",jabatan:""}),b=async()=>{t.post(route("dashboard.pkwt-detail.store"),{preserveScroll:!0,onFinish:()=>{},onSuccess:()=>{x.fire({title:"Berhasil disimpan!",icon:"success",showCloseButton:!0}),n.addEventListener("hidden.bs.modal",a=>{p.redrawDataTableChild()}),i.hide()}})};return f(()=>{flatpickr(".flatpickr-no-config",{dateFormat:"Y-m-d"}),i=new bootstrap.Modal(document.getElementById("inlineForm")),i.show(),n=document.getElementById("inlineForm"),n.addEventListener("hidden.bs.modal",h);let a=document.querySelectorAll(".choices2");for(let s=0;s<a.length;s++)a[s].classList.contains("multiple-remove")?new Choices(a[s],{delimiter:",",editItems:!0,maxItemCount:-1,removeItemButton:!0}):new Choices(a[s])}),(a,s)=>(w(),v("form",{onSubmit:k(b,["prevent"]),autocomplete:"off",novalidate:""},[e("div",C,[e("div",S,[e("div",B,[F,e("div",L,[M,e("div",E,[d(e("input",{type:"text",placeholder:"",class:c(["form-control",{"is-invalid":o(t).errors.nama_pekerja}]),"onUpdate:modelValue":s[0]||(s[0]=l=>o(t).nama_pekerja=l),autocomplete:"off"},null,2),[[r,o(t).nama_pekerja]]),e("div",I,m(o(t).errors.nama_pekerja),1)]),T,e("div",V,[d(e("input",{type:"text",placeholder:"",class:c(["form-control flatpickr-no-config flatpickr-input",{"is-invalid":o(t).errors.tgl_lahir}]),"onUpdate:modelValue":s[1]||(s[1]=l=>o(t).tgl_lahir=l),autocomplete:"off"},null,2),[[r,o(t).tgl_lahir]]),e("div",D,m(o(t).errors.tgl_lahir),1)]),N,e("div",P,[d(e("input",{type:"text",placeholder:"",class:c(["form-control",{"is-invalid":o(t).errors.jabatan}]),"onUpdate:modelValue":s[2]||(s[2]=l=>o(t).jabatan=l),autocomplete:"off"},null,2),[[r,o(t).jabatan]]),e("div",U,m(o(t).errors.jabatan),1)])]),e("div",q,[z,e("button",{type:"submit",class:"btn btn-primary ms-1",disabled:o(t).processing},O,8,A)])])])])],40,j))}};export{ee as default};
