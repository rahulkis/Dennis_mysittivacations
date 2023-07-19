<?php
  /**
  * Class: Pager
  *
  * This class can be used for pagination
  *
  * @author Mohammad Sajjad Hossain
  *         msh134@gmail.com, info@sajjadhossain.com
  */
  class Pager
  {
	  var $url = '';
	  var $sql = '';
	  var $pageIndex = 1;
	  var $rowPerPage = 5;
	  var $totalRecords = 0;
	  var $totalPages = 0;
	  var $startIndex = 0;
	  var $endIndex = 0;
	  var $nextLink = '';
	  var $previousLink = '';
	  var $pageIndexVar = 'pageIndex';

	  function Pager($sql = '')
	  {
		  $this->sql = $sql;
		  $index = isset($_REQUEST[ $this->pageIndexVar ]) ? $_REQUEST[ $this->pageIndexVar ] : 1;
		  $this->pageIndex = ((int) $index == 0) ? 1 : $index;
	  }

	  function getTotalRecords()
	  {
		  if($this->sql)
		  {
			  //counting total number of rows
			  $sql = 'SELECT COUNT(*) FROM (' . $this->sql . ') abc';
			  $query = @mysql_query($sql);
			  $row = @mysql_fetch_row($query);
			  $this->totalRecords = $row[0];
		  }

		  return $this->totalRecords;
	  }

	  function getTotalPages()
	  {
		  if($this->sql)
		  {
			  $this->totalPages = (int) ceil($this->totalRecords/$this->rowPerPage);
		  }

		  return $this->totalPages;
	  }

	  function setPageIndex()
	  {
		  $totalPages='';
		  if($this->pageIndex > $this->totalPages)
		  {
			  $pageIndex = $totalPages;
		  }
	  }

	  function setStartIndex()
	  {
		  $this->startIndex = ($this->pageIndex - 1) * $this->rowPerPage;
	  }

	  function setEndIndex()
	  {
		  if($this->totalRecords > $this->rowPerPage)
		  {
			  $this->endIndex = $this->startIndex + $this->rowPerPage;
		  }
		  else
		  {
			  $endIndex = $this->totalRecords;
		  }

		  if($this->pageIndex == $this->totalPages)
		  {
			  if($this->totalRecords < $this->totalPages * $this->rowPerPage)
			  {
				  $endIndex = $this->totalRecords;
			  }
		  }
	  }

	  function getRangeText()
	  {
		  if($this->totalRecords > 0)
		  {
			  $rangeStart = $this->startIndex + 1;

			  if(($this->totalRecords < $this->rowPerPage) || ($this->pageIndex == $this->totalPages))
			  {
				  $rangeEnd = $this->totalRecords;
			  }
			  else
			  {
				  $rangeEnd = $this->endIndex;
			  }

			  return 'Showing '  . $rangeStart . ' - ' . $rangeEnd . ' of ' . $this->totalRecords;
		  }
	  }

	  function build()
	  {
		  $this->getTotalRecords();
		  $this->getTotalPages();
		  $this->setPageIndex();
		  $this->setStartIndex();
		  $this->setEndIndex();

		  // link for next page
		  $this->nextLink = $this->url . '?' . $this->pageIndexVar . '=' . ($this->pageIndex + 1);

		  // link for previous page
		  $this->previousLink = $this->url . '?' . $this->pageIndexVar . '=' . ($this->pageIndex - 1);

		  $this->sql .= ' LIMIT ' . $this->startIndex . ', ' .  $this->rowPerPage;
	  }

	  function getPagedData()
	  {
		  $query = mysql_query($this->sql);

		  $rows = array();

		  if($query)
		  {
			  while($row = mysql_fetch_assoc($query))
			  {
				  $rows[] = $row;
			  }
		  }
		  return $rows;
	  }

	  function getNumberLinks()
	  {
		  $links = '';

		  for($i = 1; $i <= $this->totalPages; $i++)
		  {		
		  	  if($_GET['pageIndex']==$i){
			  $links .=  '<strong>'.$i.'</strong>';
			  }else
			  {
				  $links .= '<a href="' . $this->url . '?'  . $this->pageIndexVar . '=' . $i .'">' . $i . '</a> ';
			   }
		  }

		  return $links;
	  }
  }
?>
