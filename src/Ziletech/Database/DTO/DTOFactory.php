<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\Center;
use Ziletech\Database\Entity\GenericCode;

class DTOFactory {

    public static function getUserDTO($user = null): UserDTO {
        return new UserDTO($user);
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

    /**
     * @param GenericCode|null $genericCode
     * @return GenericCodeDTO
     */
    public static function getGenericCodeDTO(?GenericCode $genericCode): GenericCodeDTO {
        return new GenericCodeDTO($genericCode);
    }

    /**
     * @param Center|null $center
     * @return CenterDTO
     */
    public static function getCenterDTO(?Center $center): CenterDTO {
        return new CenterDTO($center);
    }

    public static function getCentersDTO(): CentersDTO {
        return new CentersDTO();
    }

    public static function getCodeTypeDTO(): CodeTypeDTO {
        return new CodeTypeDTO();
    }

}
