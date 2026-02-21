<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - Ashis Auto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{font-family:Inter,ui-sans-serif,system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial; background:#0f172a;} .card{background:linear-gradient(180deg,#0ea5e9 0%,#06b6d4 100%); padding:3px; border-radius:18px}</style>
  </head>
  <body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full">
      <div class="card shadow-lg">
        <div class="bg-white rounded-xl p-8">
          <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 bg-slate-900 rounded-lg flex items-center justify-center text-white font-black">AS</div>
            <div>
              <h1 class="text-2xl font-extrabold text-slate-800">Welcome back</h1>
              <p class="text-sm text-slate-500">Sign in to continue to Overtime Portal</p>
            </div>
          </div>

          @if($errors->any())
            <div class="mb-4 text-sm text-red-600">{{ $errors->first() }}</div>
          @endif

          <form method="POST" action="/login" class="space-y-4">
            @csrf
            <div>
              <label class="text-xs text-slate-600">Email</label>
              <input name="email" type="email" required class="w-full mt-1 p-3 border rounded-lg" value="{{ old('email') }}" />
            </div>
            <div>
              <label class="text-xs text-slate-600">Password</label>
              <input name="password" type="password" required class="w-full mt-1 p-3 border rounded-lg" />
            </div>
            <div class="flex items-center justify-between">
              <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" /> Remember</label>
              <a href="#" class="text-sm text-blue-600">Need help?</a>
            </div>
            <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-lg font-bold">Sign In</button>
          </form>

          <div class="mt-6 text-center text-sm text-slate-500">Don't have an account? Ask super admin to create one.</div>
        </div>
      </div>
    </div>
  </body>
</html>