package ticketrecognition.web.template;

import ticketrecognition.Role;
import ticketrecognition.dto.TemplateDto;

import javax.annotation.security.RolesAllowed;
import javax.inject.Inject;
import javax.ws.rs.Consumes;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.core.MediaType;
import java.io.IOException;

@Path("/templates/")
@RolesAllowed({Role.AD_CODE})
public class TemplateResource {

    private TemplateService service;

    @POST
    @Consumes(MediaType.APPLICATION_JSON)
    public void create(TemplateDto templateDto) throws IOException {
        service.create(templateDto);
    }

    @Inject
    void setService(TemplateService service) {
        this.service = service;
    }
}
