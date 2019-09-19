<?php
function paging($limit, $page, $search, $disp =3)
	{
		$next = $page + 1;
		$prev = $page - 1;

		$start = ($page-floor($disp/2)>0)?($page - floor($disp/2)):1;
		$end = ($start>1)?($page + floor($disp/2)):$disp;
		$start = ($limit < $end)? $start-($end-$limit):$start;

		if($page != 1)
		{
			if($search != "")
			{
				print '<a href="?page=' . $prev . '&search=' . $search . '">'. '前へ' . '</a>';
			}else
			{
				print '<a href="?page=' . $prev . '">' . '前へ' . '</a>';
			}		
		}

		if($page >= floor($disp/2))
		{
			if($page != 1)
			{
				if($search != ""){
					print '<a href="?page=1&search='.$search.'">1</a>';
				}else
				{
					print '<a href="?page=1">1</a>';
				}
			}
			if($start > floor($disp/2) && ($start -floor($disp/2)) !=1) print "...";
		}
		
		for($i=$start;$i<=$end;$i++)
		{
			$class = ($page == $i)?' class="current"':"";
			if($i <= $limit && $i >1 && $i != $page)
			{
				if($search != "")
				{
					print '<a href="?page=' . $i . '&search=' . $search . '">'. $i . '</a>';
				}else
				{
					print '<a href="?page=' . $i . '"' . $class . '>'. $i . '</a>';
				}			
			}

			if($i == $page)
			{
				print'<a>'.$i.'</a>';
			}

		}

		if($limit > $end)
		{
			if($limit-1 > $end) print "...";
			if($page != $end)
			{
				if($search != "")
				{
					print '<a href="?page=' . $limit . '&search='. $search . '">'.$limit.'</a>';	
				}else
				{
					print '<a href="?page=' . $limit . '">' . $limit . '</a>';
				}
			}
		}
		if($page < $limit)
		{
			if($search != "")
			{
				print '<a href="?page=' .$next .'&search=' .$search. '">'.'次へ'.'</a>'; 
			}else
			{
				print '<a href="?page=' . $next . '">' . '次へ' . '</a>';
			}
		}
	}
?>
