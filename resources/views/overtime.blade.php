<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ashis Auto Solution - Fixed Design</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <style>
      body { font-family: "Hind Siliguri", sans-serif; background: #f8fafc; }
      .glass { background: white; border: 1px solid #e2e8f0; }
      .gradient-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
      .card-hover:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1); transition: all 0.3s ease; }
      #detailsModal { display: none; }
    </style>
  </head>
  <body class="p-4 md:p-10">
    <div class="max-w-7xl mx-auto">
      
      
      <div class="gradient-header rounded-3xl p-8 mb-10 text-white shadow-xl flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
        <div class="flex flex-col z-10 text-center md:text-left">
          <h1 class="text-3xl font-black tracking-tight text-white uppercase">
            Ashis Auto Solution
          </h1>
          <div class="mt-1 text-[11px] text-blue-200 uppercase tracking-wider font-semibold">
            <p>Madani Avenue, Badda, Dhaka</p>
          </div>
        </div>

        <div class="my-4 md:my-0 z-10">
          <div class="bg-white/10 backdrop-blur-md border border-white/20 px-6 py-2 rounded-2xl shadow-inner">
            <span class="text-sm font-bold text-white uppercase tracking-[0.2em]">
              Overtime Payment Portal
            </span>
          </div>
        </div>

        <div class="text-center md:text-right z-10">
          <p class="text-[10px] uppercase font-bold text-blue-300 mb-1">
            System Live Date
          </p>
          <div id="liveDateDisplay" class="text-xl font-bold text-white"></div>
          @if(session('user_name'))
            <div class="mt-2 text-sm text-blue-200">Logged in: {{ session('user_name') }} ({{ session('user_role') }})</div>
            <form method="POST" action="/logout" class="mt-2">
              @csrf
              <button type="submit" class="text-sm text-red-200 underline">Logout</button>
            </form>
          @endif
        </div>

        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500 rounded-full blur-[80px] opacity-20"></div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4 no-print">
          <div class="glass p-6 rounded-2xl shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 border-b pb-2 mb-6">Entry Form</h2>
            <form id="otForm" class="space-y-4">
              <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 mb-4">
                <p class="text-[10px] font-bold text-blue-600 uppercase mb-3 underline">Main Entry</p>
                <div class="grid grid-cols-2 gap-3">
                  <div class="col-span-2">
                    <label class="text-xs font-bold text-slate-500 uppercase">Employee Name</label>
                    <input type="text" id="name" required class="w-full p-3 bg-white border rounded-xl outline-none focus:ring-2 focus:ring-blue-500" />
                  </div>
                  <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Department</label>
                    <select id="dept" required class="w-full p-3 bg-white border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                      <option value="Management">Management</option>
                      <option value="Engine">Engine</option>
                      <option value="Denting">Denting</option>
                      <option value="Painting">Painting</option>
                      <option value="Security">Security</option>
                    </select>
                  </div>
                  <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Date</label>
                    <input type="date" id="otDate" required class="w-full p-3 bg-white border rounded-xl" />
                  </div>
                  <div class="col-span-2">
                    <label class="text-xs font-bold text-slate-500 uppercase">Salary (৳)</label>
                    <input type="number" id="salary" required class="w-full p-3 bg-white border rounded-xl" />
                  </div>
                  <div class="col-span-2">
                    <label class="text-xs font-bold text-slate-500 uppercase">Description</label>
                    <textarea id="description" class="w-full p-3 bg-white border rounded-xl" rows="2"></textarea>
                  </div>
                  <div><label class="text-xs font-bold text-slate-500 uppercase">Start</label><input type="time" id="inTime" required class="w-full p-3 bg-white border rounded-xl" /></div>
                  <div><label class="text-xs font-bold text-slate-500 uppercase">End</label><input type="time" id="outTime" required class="w-full p-3 bg-white border rounded-xl" /></div>
                </div>
              </div>

              <div id="multiEntryContainer" class="space-y-4"></div>

              <button type="button" onclick="addNewEntryRow()" class="w-full border-2 border-dashed border-blue-300 text-blue-600 py-3 rounded-xl font-bold hover:bg-blue-50 transition text-sm">+ Add another entry</button>
              <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-black transition">Add all entries →</button>
            </form>
          </div>
        </div>

        <div class="lg:col-span-8">
          <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-3 w-full sm:w-auto">
              <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight mr-3">Voucher Cards</h2>
              <label class="text-xs text-slate-500">Filter by date:</label>
              <input type="date" id="filterStart" class="p-2 border rounded-lg" />
              <input type="date" id="filterEnd" class="p-2 border rounded-lg" />
              <button id="applyFilterBtn" class="bg-blue-600 text-white px-3 py-2 rounded-xl text-xs font-bold">Apply</button>
              <button id="resetFilterBtn" class="bg-white border text-slate-600 px-3 py-2 rounded-xl text-xs font-bold">Reset</button>
            </div>
            <div class="flex gap-2">
                <button onclick="downloadPDF()" class="bg-emerald-600 text-white px-5 py-2 rounded-xl font-bold text-xs shadow-md uppercase">Download All PDF</button>
                <button onclick="clearTable()" class="bg-white border text-red-500 px-4 py-2 rounded-xl font-bold text-xs hover:bg-red-50">Delete All</button>
            </div>
          </div>

          <div id="cardsGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
          
          <div id="emptyState" class="bg-white p-20 rounded-3xl border-2 border-dashed border-slate-200 text-center text-slate-300">No records found.</div>

          <div class="mt-8 p-6 bg-white rounded-2xl shadow-sm flex justify-between items-center border-l-8 border-blue-600">
            <span class="font-bold text-slate-500 uppercase tracking-widest text-xs">Total Amount</span>
            <span id="totalPay" class="text-3xl font-black text-blue-600">৳ 0.00</span>
          </div>
        </div>
      </div>
    </div>

    <div id="detailsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in duration-200">
            <div class="gradient-header p-6 text-white flex justify-between items-center">
                <h3 class="text-lg font-bold uppercase tracking-widest">Entry Details</h3>
                <button onclick="closeModal()" class="text-2xl hover:text-red-400">✕</button>
            </div>
            <div id="modalContent" class="p-8 space-y-3"></div>
            <div class="p-6 bg-slate-50 border-t flex gap-3">
                <button id="modalIndividualPDF" class="flex-1 bg-emerald-600 text-white py-3 rounded-xl font-bold uppercase text-xs">Download PDF</button>
                <button onclick="closeModal()" class="flex-1 bg-slate-200 text-slate-600 py-3 rounded-xl font-bold uppercase text-xs">Close</button>
            </div>
        </div>
    </div>

    <script>
      const { jsPDF } = window.jspdf;
      // server-provided stored entries (raw DB rows)
      const _serverEntries = @json($storedEntries ?? []);
      const _currentUser = @json($currentUser ?? null);
      let dataStore = [];

      document.getElementById("otDate").valueAsDate = new Date();
      document.getElementById("liveDateDisplay").textContent = new Date().toLocaleDateString("bn-BD", { year: "numeric", month: "long", day: "numeric" });

      function calculateAmount(salary, inTime, outTime) {
          const start = new Date(`2026-01-01 ${inTime}`);
          let end = new Date(`2026-01-01 ${outTime}`);
          if (end < start) end.setDate(end.getDate() + 1);
          const diffHrs = (end - start) / (1000 * 60 * 60);
          const amount = diffHrs * (parseFloat(salary) / 240);
          return { hrs: diffHrs.toFixed(2), amount: amount.toFixed(2) };
      }

        function formatTime(timeString) {
          if (!timeString) return '';
          const parts = timeString.split(":");
          const hour = parts[0];
          const minute = parts[1] ?? '00';
          let h = parseInt(hour);
          const ampm = h >= 12 ? "PM" : "AM";
          h = h % 12 || 12;
          return `${h}:${minute} ${ampm}`;
        }

      function addNewEntryRow() {
          const container = document.getElementById('multiEntryContainer');
          const row = document.createElement('div');
          row.className = "p-4 bg-white border-2 border-slate-200 rounded-2xl relative mb-4 extra-entry";
            const defaultDate = document.getElementById('otDate') ? document.getElementById('otDate').value : '';
            row.innerHTML = `<button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-500 text-white w-6 h-6 rounded-full text-xs">✕</button><div class="grid grid-cols-2 gap-3"><div class="col-span-2"><input type="text" placeholder="Name" class="name-field w-full p-2 border rounded-lg text-sm" required /></div><div><select class="dept-field w-full p-2 border rounded-lg text-sm"><option value="Management">Management</option><option value="Engine">Engine</option><option value="Denting">Denting</option><option value="Painting">Painting</option><option value="Security">Security</option></select></div><div><input type="date" class="date-field w-full p-2 border rounded-lg text-sm" value="${defaultDate}" required /></div><div><input type="number" placeholder="Salary" class="salary-field w-full p-2 border rounded-lg text-sm" required /></div><div><input type="time" class="in-field w-full p-2 border rounded-lg text-sm" required /></div><div><input type="time" class="out-field w-full p-2 border rounded-lg text-sm" required /></div><div class="col-span-2"><input type="text" placeholder="Description" class="description-field w-full p-2 border rounded-lg text-sm" /></div></div>`;
          container.appendChild(row);
      }
      
        function formatDate(dateStr) {
          if (!dateStr) return '';
          const d = new Date(dateStr);
          if (!isNaN(d)) {
            return d.toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' });
          }
          const m = String(dateStr).match(/^(\d{4})-(\d{2})-(\d{2})/);
          if (m) return `${m[3]}-${m[2]}-${m[1]}`;
          return dateStr;
        }

          document.getElementById("otForm").addEventListener("submit", async function (e) {
          e.preventDefault();
          const commonDate = document.getElementById("otDate").value;
          const entries = [];
          // main entry
          const mainSalary = document.getElementById("salary").value;
          const mainIn = document.getElementById("inTime").value;
          const mainOut = document.getElementById("outTime").value;
          const mRes = calculateAmount(mainSalary, mainIn, mainOut);
          entries.push({ name: document.getElementById("name").value, dept: document.getElementById("dept").value, date: commonDate, salary: mainSalary, in: mainIn, out: mainOut, hrs: mRes.hrs, amount: mRes.amount, description: document.getElementById("description").value });

          // extra entries
            document.querySelectorAll('.extra-entry').forEach(row => {
            const s = row.querySelector('.salary-field').value;
            const i = row.querySelector('.in-field').value;
            const o = row.querySelector('.out-field').value;
            const res = calculateAmount(s, i, o);
            const rowDateEl = row.querySelector('.date-field');
            const rowDate = rowDateEl && rowDateEl.value ? rowDateEl.value : commonDate;
            entries.push({ name: row.querySelector('.name-field').value, dept: row.querySelector('.dept-field').value, date: rowDate, salary: s, in: i, out: o, hrs: res.hrs, amount: res.amount, description: row.querySelector('.description-field') ? row.querySelector('.description-field').value : '' });
          });

          // send to server to persist
          try {
            const resp = await fetch("/overtime/save", {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ entries })
            });
            if (!resp.ok) throw resp;
            const json = await resp.json();
            // append saved items to local store and refresh UI
            json.saved.forEach(item => {
              const displayDate = item.ot_date ? formatDate(item.ot_date) : item.ot_date;
              const period = `${formatTime(item.in_time)} - ${formatTime(item.out_time)}`;
              dataStore.push({ id: item.id, name: item.name, dept: item.dept, salary: item.salary, date: item.ot_date, displayDate, period, hrs: item.hrs, amount: item.amount, description: item.description ?? '' });
            });
            updateUI();
            this.reset();
            document.getElementById('multiEntryContainer').innerHTML = '';
            document.getElementById("otDate").valueAsDate = new Date();
            // success toast
            Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 3000}).fire({icon: 'success', title: `Saved ${json.saved.length} entr${json.saved.length>1?'ies':'y'}`});
          } catch (err) {
            console.error('Save failed', err);
            Swal.fire({icon: 'error', title: 'Save failed', text: 'Check console for details.'});
          }
        });

        function saveToStore(name, dept, date, salary, inT, outT, res) {
          dataStore.push({ id: Date.now() + Math.random(), name, dept, salary, date, displayDate: formatDate(date), period: `${formatTime(inT)} - ${formatTime(outT)}`, hrs: res.hrs, amount: res.amount });
        }

        // Initialize client store from server-provided entries
        (function initFromServer(){
          if (!_serverEntries || !_serverEntries.length) return;
          _serverEntries.forEach(item => {
            const displayDate = item.ot_date ? formatDate(item.ot_date) : '';
            const period = `${formatTime(item.in_time)} - ${formatTime(item.out_time)}`;
            dataStore.push({ id: item.id, name: item.name, dept: item.dept, salary: item.salary, date: item.ot_date, displayDate, period, hrs: item.hrs, amount: item.amount, description: item.description ?? '' });
          });
          updateUI();
        })();

          // Fetch filtered list from server and replace dataStore
          async function fetchFiltered(start, end) {
            const params = new URLSearchParams();
            if (start) params.append('start', start);
            if (end) params.append('end', end);
            const res = await fetch('/overtime/list?' + params.toString());
            if (!res.ok) throw new Error('Failed to fetch');
            const json = await res.json();
            dataStore = [];
            json.data.forEach(item => {
              const displayDate = item.ot_date ? formatDate(item.ot_date) : '';
              const period = `${formatTime(item.in_time)} - ${formatTime(item.out_time)}`;
              dataStore.push({ id: item.id, name: item.name, dept: item.dept, salary: item.salary, date: item.ot_date, displayDate, period, hrs: item.hrs, amount: item.amount, description: item.description ?? '' });
            });
            updateUI();
          }

          // Hook up filter buttons
          document.addEventListener('DOMContentLoaded', function(){
            const applyBtn = document.getElementById('applyFilterBtn');
            const resetBtn = document.getElementById('resetFilterBtn');
            applyBtn?.addEventListener('click', function(){
              const s = document.getElementById('filterStart').value;
              const e = document.getElementById('filterEnd').value;
              fetchFiltered(s, e).catch(err => { console.error(err); alert('Failed to load filtered data'); });
            });
            resetBtn?.addEventListener('click', function(){
              document.getElementById('filterStart').value = '';
              document.getElementById('filterEnd').value = '';
              // reload all
              fetchFiltered().catch(err => { console.error(err); alert('Failed to load data'); });
            });
          });

      function updateUI() {
          const grid = document.getElementById("cardsGrid");
          grid.innerHTML = "";
          let total = 0;
          dataStore.forEach((item) => {
              total += parseFloat(item.amount);
              grid.innerHTML += `
              <div class="bg-white border border-slate-200 p-5 rounded-2xl card-hover flex flex-col justify-between">
                  <div>
                    <div class="flex justify-between items-start mb-2"><span class="text-[9px] font-black text-blue-600 uppercase tracking-widest">${item.dept}</span><span class="text-[10px] font-bold text-slate-400">${item.displayDate}</span></div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">${item.name}</h3>
                    <p class="text-[11px] text-slate-500">${item.period} (${item.hrs} Hrs)</p>
                    <p class="text-sm text-slate-400 mt-2">${item.description || ''}</p>
                  </div>
                    <div class="flex justify-between items-center mt-5 border-t pt-4">
                      <div class="text-lg font-black text-slate-900">৳ ${item.amount}</div>
                      <div class="flex gap-1">
                        <button onclick="downloadIndividualPDF('${item.id}')" class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg text-[10px] font-bold">PDF</button>
                        <button onclick="showDetails('${item.id}')" class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-[10px] font-bold">DETAILS</button>
                        <button onclick="deleteEntry('${item.id}')" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-[10px] font-bold">DELETE</button>
                      </div>
                    </div>
              </div>`;
          });
          document.getElementById("emptyState").style.display = dataStore.length ? "none" : "block";
          document.getElementById("totalPay").textContent = `৳ ${total.toFixed(2)}`;
      }

      function showDetails(id) {
          const item = dataStore.find(i => i.id == id);
          document.getElementById("modalContent").innerHTML = `
              <div class="flex justify-between border-b pb-1 text-sm"><strong>Name:</strong> <span>${item.name}</span></div>
              <div class="flex justify-between border-b pb-1 text-sm"><strong>Dept:</strong> <span>${item.dept}</span></div>
              <div class="flex justify-between border-b pb-1 text-sm"><strong>Basic Salary:</strong> <span>৳ ${item.salary}</span></div>
              <div class="flex justify-between border-b pb-1 text-sm"><strong>OT Date:</strong> <span>${item.displayDate}</span></div>
              <div class="flex justify-between border-b pb-1 text-sm"><strong>Description:</strong> <span>${item.description || ''}</span></div>
              <div class="flex justify-between border-b pb-1 text-sm"><strong>Total Hrs:</strong> <span class="text-blue-600 font-bold">${item.hrs} Hrs</span></div>
              <div class="flex justify-between text-lg font-black text-slate-900 pt-2"><strong>Bill Amount:</strong> <span>৳ ${item.amount}</span></div>
          `;
          document.getElementById("modalIndividualPDF").onclick = () => downloadIndividualPDF(id);
          document.getElementById("detailsModal").style.display = "flex";
      }

      function closeModal() { document.getElementById("detailsModal").style.display = "none"; }

        async function deleteEntry(id) {
          const result = await Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently delete the record.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
          });
          if (!result.isConfirmed) return;
          try {
            const resp = await fetch(`/overtime/${id}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
              }
            });
            if (!resp.ok) throw resp;
            // remove from client store and update UI
            dataStore = dataStore.filter(i => i.id != id);
            updateUI();
            Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 2500}).fire({icon: 'success', title: 'Record deleted'});
          } catch (err) {
            console.error('Delete failed', err);
            Swal.fire({icon: 'error', title: 'Delete failed', text: 'Check console for details.'});
          }
        }

        // update clearTable to delete from server as well
        async function clearTable() {
          const result = await Swal.fire({
            title: 'Delete all records?',
            text: 'This will permanently delete ALL overtime records.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete all',
            cancelButtonText: 'Cancel'
          });
          if (!result.isConfirmed) return;
          try {
            const resp = await fetch('/overtime', {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
              }
            });
            if (!resp.ok) throw resp;
            dataStore = [];
            updateUI();
            Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 2500}).fire({icon: 'success', title: 'All records deleted'});
          } catch (err) {
            console.error('Clear failed', err);
            Swal.fire({icon: 'error', title: 'Clear failed', text: 'Failed to delete records. Check console for details.'});
          }
        }

      // [RESTORED] ORIGINAL PROFESSIONAL PDF DESIGN LOGIC
      function generatePDF(dataArray, filename) {
          const doc = new jsPDF("l", "mm", "a4");
          const pageWidth = doc.internal.pageSize.width;
          const addHeader = (pdf) => {
              pdf.setTextColor(24, 24, 55); pdf.setFontSize(22); pdf.setFont("helvetica", "bold"); pdf.text("ASHIS AUTO SOLUTION", 15, 15);
              pdf.setFontSize(10); pdf.setFont("helvetica", "normal"); pdf.setTextColor(80, 80, 80);
              pdf.text("Address: Madani Avenue, Beraid, Badda, Dhaka 1212. Phone: 01712287659", 15, 21);
              pdf.setDrawColor(24, 24, 55); pdf.setLineWidth(0.6); pdf.line(15, 25, pageWidth - 15, 25);
          };
          const tableRows = dataArray.map((item, idx) => [idx + 1, `${item.name}\n(${item.dept})`, item.displayDate, item.description || "Overtime Duty", item.period, item.hrs, `${item.amount} TK`, ""]);
          doc.autoTable({
              head: [["SL", "Employee Name", "OT Date", "Description", "Time Period", "Hrs", "Amount", "Employee Sig."]],
              body: tableRows, startY: 40, theme: "grid",
              headStyles: { fillColor: [24, 24, 55], textColor: 255, halign: "center", fontSize: 10 },
              styles: { fontSize: 9.5, cellPadding: 3, valign: "middle" },
              columnStyles: { 0: { halign: "center", cellWidth: 10 }, 5: { halign: "center" }, 6: { halign: "right", fontStyle: "bold" }, 7: { cellWidth: 40 } },
              didDrawPage: (data) => {
                  addHeader(doc);
                  doc.setTextColor(0); doc.setFontSize(14); doc.text("OVERTIME PAYMENT BILL", pageWidth / 2, 32, { align: "center" });
              }
          });
          const totalSum = dataArray.reduce((a, b) => a + parseFloat(b.amount), 0);
          doc.setFontSize(12); doc.text(`Total Amount: ${totalSum.toFixed(2)} TK`, pageWidth - 15, doc.lastAutoTable.finalY + 10, { align: "right" });
          doc.save(filename);
      }

      function downloadPDF() { if (dataStore.length > 0) generatePDF(dataStore, "Ashis_Auto_Full_Report.pdf"); }
      function downloadIndividualPDF(id) { const item = dataStore.find(i => i.id == id); generatePDF([item], `Report_${item.name}.pdf`); }
    </script>
  </body>
</html>
