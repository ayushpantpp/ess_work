
<table>

<tr><td>First Name: </td><td><?php echo $emplist[0]['Employee']['emp_firstname'];?></td></tr>
<tr><td>Last Name: </td><td><?php echo $emplist[0]['Employee']['emp_lastname'];?></td></tr>
<tr><td>Employee code: </td><td><?php echo $emplist[0]['Employee']['emp_code'];?></td></tr>
<tr><td>Department Name: </td><td><?php $dept=$this->Common->getdepartmentbyid($emplist[0]['Employee']['dept_code']);
									echo $dept; ?></td></tr>
<tr><td>Designation Name: </td><td> <?php $desg=$this->Common->findDesignationNameByCode($emplist[0]['Employee']['desg_code']);
									echo $desg; ?></td></tr>
<tr><td>Company Name: </td><td><?php $comp=$this->Common->findCompanyNameByCode($emplist[0]['Employee']['comp_code']);
									echo $comp;
?></td></tr>
<tr><td>Email: </td><td><?php $user=$this->Common->findUserDetailByEmpCode($emplist[0]['Employee']['emp_code']);
									echo $user[0]['UserDetail']['email'];
?></td></tr>
<tr><td>Gender: </td><td><?php echo $emplist[0]['Employee']['gender'];?></td></tr>

<tr><td>Contact: </td><td><?php echo $emplist[0]['Employee']['contact'];?></td></tr>

</table>