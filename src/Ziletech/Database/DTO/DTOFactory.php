<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\GenericCode;

class DTOFactory {

    public static function getUserDTO($user = null): UserDTO {
        return new UserDTO($user);
    }

    public static function getUserTreeDTO($userTree = null): UserTreeDTO {
        return new UserTreeDTO($userTree);
    }

    public static function getContactUsDTO(): ContactUsDTO {
        return new ContactUsDTO();
    }

    public static function getUserLoginDTO(): UserLoginDTO {
        return new UserLoginDTO();
    }

    public static function getFileDTO($fileDTO = null): FileDTO {
        return new FileDTO($fileDTO);
    }

    public static function getRoleDTO($roleDTO = null): RoleDTO {
        return new RoleDTO($roleDTO);
    }

    public static function getSettingDTO(): SettingDTO {
        return new SettingDTO();
    }

    public static function getGenericCodeDTO(?GenericCode $genericCode): GenericCodeDTO {
        return new GenericCodeDTO($genericCode);
    }

    public static function getCodeTypeDTO(): CodeTypeDTO {
        return new CodeTypeDTO();
    }

}
