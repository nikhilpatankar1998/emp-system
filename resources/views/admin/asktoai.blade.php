<style>
    @media screen and (max-width: 640px) {
        div.dt-buttons {
            float: none !important;
            text-align: start !important;
        }
    }

.body-wrapper .app-header{
  width: calc(100% - 270px) !important;
  }

.body-wrapper.collapsed-sidebar .app-header{
  width: calc(100% - 80px) !important;
  }


 #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper .app-header {
    width: calc(100% - 270px) !important;
    transition: all 0.3s ease !important;
  }

  #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper.collapsed-sidebar .app-header {
    width: calc(100% - 80px) !important;
    transition: all 0.3s ease !important;
  }

 /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .body-wrapper.collapsed-sidebar .app-header {
    width: calc(100% - 270px) !important;
  }
  

  /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .app-header {
    width: calc(100% - 270px) !important;
  }

  /* Body wrapper default */
  .body-wrapper {
    margin-left: 270px !important;
    transition: all 0.3s ease !important;
  }

  /* Body wrapper when sidebar collapsed */
  .body-wrapper.collapsed-sidebar {
    margin-left: 80px !important;
  }

/* Small screens (below 1200px) */
@media (max-width: 1199px) {
  /* Sidebar hidden by default */
  #main-wrapper[data-layout=vertical] .left-sidebar {
    left: -100% !important;
    transition: all 0.3s ease !important;
  }

  /* Sidebar shown (mobile toggle) */
  #main-wrapper[data-layout=vertical].show-sidebar .left-sidebar {
    left: 0 !important;
  }
  
  .body-wrapper {
    margin-left: auto !important;
    transition: all 0.3s ease !important;
  }
  .app-header{
  width: 100% !important;
  }

   #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper .app-header {
    width: 100% !important;
    transition: all 0.3s ease !important;
  }

  #main-wrapper [data-layout=vertical][data-header-position=fixed] .body-wrapper.collapsed-sidebar .app-header {
    width: 100% !important;
    transition: all 0.3s ease !important;
  }

  

  /* Header when sidebar collapsed */
    #main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .app-header {
    width: 100% !important;
  }

.body-wrapper .app-header{
  width: 100% !important;
  }

.body-wrapper.collapsed-sidebar .app-header{
  width: 100% !important;
  }

.body-wrapper {
    margin-left: auto !important;
    transition: all 0.3s ease !important;
  }

  /* Body wrapper when sidebar collapsed */
  .body-wrapper.collapsed-sidebar {
    margin-left: auto !important;
  }

#main-wrapper[data-layout=vertical][data-header-position=fixed][data-sidebartype=mini-sidebar] .body-wrapper.collapsed-sidebar .app-header {
    width: 100% !important; 
}

.left-sidebar.collapsed {
    width: 100% !important;
}

}
</style>

@include('admin.layouts.head')

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('admin.layouts.sidebar')

        <div class="body-wrapper">

            @include('admin.layouts.header')

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <h4>Dodo AI Assistant</h4>
                                {{-- <form method="POST" action="{{ route('ai.sendText') }}"> --}}
                                <form id="aiForm">
                                    @csrf
                                    {{-- <input type="text" id="userText" placeholder="Ask something..." style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" required> --}}
                                    <textarea id="userText" placeholder="Ask something..." required rows="4" class="mb-2"
                                        style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; resize: vertical; width: 100%; "></textarea>
                                    <button type="submit"
                                        style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 6px; cursor: pointer;">
                                        🔍 Ask</button>
                                    <button type="button" id="resetBtn"
                                        style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 6px; cursor: pointer;">
                                        Clear
                                    </button>
                                </form>

                                <div id="ai-response" style="margin-top: 20px;"></div>

                                <script>
                                    document.getElementById('aiForm').addEventListener('submit', async function(e) {
                                        e.preventDefault();

                                        const text = document.getElementById('userText').value;
                                        const responseContainer = document.getElementById('ai-response');
                                        responseContainer.innerHTML = "<p><em>Loading...</em></p>";

                                        const token = document.querySelector('input[name="_token"]').value;

                                        try {
                                            const res = await fetch("{{ route('ai.sendText') }}", {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': token,
                                                },
                                                body: JSON.stringify({
                                                    text: text
                                                })
                                            });

                                            const result = await res.json();

                                            if (res.ok) {
                                                responseContainer.innerHTML = formatAIResponse(result);
                                            } else {
                                                responseContainer.innerHTML = "<p style='color:red;'>" + result.error + "</p>";
                                            }

                                        } catch (error) {
                                            responseContainer.innerHTML = "<p style='color:red;'>JS Error: " + error.message + "</p>";
                                        }
                                    });

                                    function formatAIResponse(response) {
                                        let html = `
                                        <div style="
                                            background: #f9f9f9;
                                            border: 1px solid #ddd;
                                            border-radius: 10px;
                                            padding: 16px;
                                            margin-top: 20px;
                                            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                                            font-family: 'Segoe UI', sans-serif;
                                        ">
                                    `;

                                        // Chat-style message bubble
                                        if (response.message) {
                                            html += `
                                       <div style="
                                           background: #e1f5fe;
                                           padding: 10px 14px;
                                           border-radius: 10px;
                                           max-width: 90%;
                                           margin-bottom: 15px;                                
                                           display: inline-block;
                                       ">
                                           <strong>🤖 Response:</strong><br>${response.message}
                                       </div>
                                   `;
                                        }

                                        // Table for results
                                        if (Array.isArray(response.results) && response.results.length > 0) {
                                            const keys = Object.keys(response.results[0]);

                                            html += `
                                            <div style="overflow-x: auto;">
                                            <table style="
                                                width: 100%;
                                                border-collapse: collapse;
                                                margin-top: 10px;
                                                font-size: 14px;
                                            ">
                                                <thead>
                                                    <tr style="background-color: #eeeeee;">
                                        `;

                                            keys.forEach(key => {
                                                html +=
                                                    `<th style="padding: 10px; border: 1px solid #ddd;">${key.replace(/_/g, ' ').toUpperCase()}</th>`;
                                            });

                                            html += `</tr></thead><tbody>`;

                                            response.results.forEach(item => {
                                                html += "<tr>";
                                                keys.forEach(key => {
                                                    html +=
                                                        `<td style="padding: 10px; border: 1px solid #ddd;">${item[key] !== null ? item[key] : '-'}</td>`;
                                                });
                                                html += "</tr>";
                                            });

                                            html += `</tbody></table></div>`;
                                        } else {
                                            html += "<p style='color: gray; font-style: italic;'>No results found.</p>";
                                        }

                                        html += "</div>"; // Close outer card

                                        return html;
                                    }
                                </script>
                                <script>
                                    document.getElementById('resetBtn').addEventListener('click', function() {
                                        document.getElementById('userText').value = '';
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('admin.layouts.footer')
