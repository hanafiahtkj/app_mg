/* empty css                               *//* empty css                */import{S as r}from"./sweetalert2.all-2d76b64b.js";/* empty css            */import"./app-82ed81c5.js";import{T as h,m as b,x as f,j as m,b as e,t as w,a as _,w as k,u as v,o as g,i as x,O as y}from"./app-ece2a1fe.js";/* empty css                                                            */const B={class:"card"},j={class:"card-header"},D={class:"d-flex justify-content-between"},T={class:"card-title"},P=e("i",{class:"fa-fw select-all fas"},"",-1),C=e("div",{class:"card-body"},[e("div",{class:"table-responsive datatable-minimal"},[e("table",{class:"table",id:"table-data-detail"},[e("thead",null,[e("tr",null,[e("th",null,"Nama Pekerja"),e("th",null,"Tanggal Lahir"),e("th",null,"Jabatan"),e("th",null,"Action")])]),e("tbody")])])],-1),A={__name:"Index",props:{idPkwt:Number,perusahaan:{type:Object}},setup(i,{expose:c}){const l=i;let s;h({id_perusahaan:""});const u=()=>{$(document).on("click","#table-data-detail .edit-link",function(t){t.preventDefault();const a=$(this).data("user-id");y.get(route("dashboard.pkwt-detail.edit",{id:a}),{},{preserveState:!0})}),$(document).on("click","#table-data-detail .delete-link",function(t){t.preventDefault();const a=$(this).data("user-id");r.fire({title:"Yakin ingin menghapus?",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"No, cancel!",cancelButtonColor:"#d33",reverseButtons:!0}).then(d=>{d.isConfirmed&&axios.delete(route("dashboard.pkwt-detail.destroy",{id:a})).then(o=>{r.fire("Berhasil dihapus!","","success"),s.ajax.reload(null,!1)}).catch(o=>{console.error("Failed to delete user:",o)})})})},n=()=>{s&&s.ajax.reload(null,!1)},p=async()=>{try{s=$("#table-data-detail").DataTable({responsive:!0,lengthMenu:[[5,10,50,-1],[5,10,50,"All"]],ajax:{url:route("dashboard.pkwt-detail.loadPkwtDetail"),data:function(t){t.id_pkwt=l.idPkwt}},columns:[{data:"nama_pekerja"},{data:"tgl_lahir"},{data:"jabatan"},{data:null,render:function(t,a,d){return`
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon btn-default me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item edit-link" href="#" data-user-id="${d.id}">Edit</a>
                                    <a class="dropdown-item delete-link" href="#" data-user-id="${d.id}">Delete</a>
                                </div>
                            </div>
                        `}}]}),u()}catch(t){console.error("Gagal memuat data:",t)}};return b(()=>{p()}),f(l,(t,a)=>{n()}),c({redrawDataTableChild:n}),(t,a)=>(g(),m("div",B,[e("div",j,[e("div",D,[e("h5",T," Detail PKWT "+w(t.idPkwt2),1),_(v(x),{href:t.route("dashboard.pkwt-detail.create"),"preserve-state":!0,"preserve-scroll":"true",class:"btn icon btn-primary"},{default:k(()=>[P]),_:1},8,["href"])])]),C]))}};export{A as default};
