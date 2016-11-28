<ul class="reporting-nav">
    <li><a href="{{ url('sub') }}" class="btn btn-facebook btn-round">
            <i class="fa fa-home"></i> রিপোর্ট হোমপেজ
        </a></li>
    <li><a href="{{ url('sub/' . $id) }}" class="btn btn-facebook btn-round"> প্রকল্পের খরচ </a></li>
    <li><a href="{{ url('sub/'.$id.'/income') }}" class="btn btn-facebook btn-round"> প্রকল্পের কালেকশন </a></li>
    <li><a href="{{ url('sub/'.$id.'/due') }}" class="btn btn-facebook btn-round"> বকেয়া টাকার পরিমাণ </a></li>
    <li><a href="{{ url('sub/'. $id .'/balance') }}" class="btn btn-facebook btn-round"> ব্যালেন্স সীট </a></li>
</ul>