import fs from 'node:fs/promises';
import {FileBlob, SpreadsheetFile} from '@oai/artifact-tool';
const a=JSON.parse(await fs.readFile('tmp/codex-rows-0.json','utf8').then(s=>s.replace(/^\uFEFF/,'')));
const b=JSON.parse(await fs.readFile('tmp/codex-rows-1.json','utf8').then(s=>s.replace(/^\uFEFF/,'')));
const key=s=>String(s??'').normalize('NFD').replace(/[\u0300-\u036f]/g,'').toUpperCase().replace(/[^A-Z0-9]+/g,' ').trim();
const map=new Map(); for(const r of b.slice(4)){if(r[1]&&r[4]){const k=key(r[1]); if(!map.has(k))map.set(k,[]);map.get(k).push(String(r[4]).trim());}}
const wb=await SpreadsheetFile.importXlsx(await FileBlob.load('tmp/codex-invitados-base.xlsx'));
const sh=wb.worksheets.getItem('invitado_copladeps');
let count=0;for(let i=1;i<a.length;i++){let m=map.get(key(a[i][1]));if(m&&m.length===1){sh.getRange(`N${i+1}`).values=[[m[0]]];count++;}}
await fs.mkdir('outputs/clasificacion_copladep',{recursive:true});
await (await SpreadsheetFile.exportXlsx(wb)).save('outputs/clasificacion_copladep/invitados_con_categoria.xlsx');
try {const image=await wb.render({sheetName:'invitado_copladeps',range:'A1:E9',scale:1,format:'png'});await fs.writeFile('tmp/codex-invitados-preview.png',new Uint8Array(await image.arrayBuffer()));} catch(e){console.log('render:',e.message)}
console.log('Actualizados:',count);
