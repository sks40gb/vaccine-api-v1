<?php

#DB Entity
require 'Entity/EntityFactory.php';
require 'Entity/BaseEntity.php';
require 'Entity/User.php';
require 'Entity/Plan.php';
require 'Entity/UserTree.php';
require 'Entity/CodeType.php';
require 'Entity/GenericCode.php';

#DB DAO
require 'DAO/DAOFactory.php';
require 'DAO/BaseDAO.php';
require 'DAO/UserDAO.php';
require 'DAO/PlanDAO.php';
require 'DAO/UserTreeDAO.php';
require 'DAO/CodeTypeDAO.php';
require 'DAO/GenericCodeDAO.php';

#DTO
require 'DTO/DTOFactory.php';
require 'DTO/DTOMapper.php';
require 'DTO/UserDTO.php';
require 'DTO/PlanDTO.php';
require 'DTO/UserTreeDTO.php';
require 'DTO/GenericCodeDTO.php';
require 'DTO/CodeTypeDTO.php';
?>