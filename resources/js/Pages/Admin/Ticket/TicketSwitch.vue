  <template>
   <th>
                   <div class="form-check form-switch">
                    <input class="form-check-input" id="ticketStatusRow" :data-id="ticket.id" @change="ticketStatus(ticket.id)" v-if="ticket.status" checked type="checkbox" role="switch" style="width:3em;height:1.5em;">
                    <input class="form-check-input" id="ticketStatusRow" :data-id="ticket.id" @change="ticketStatus(ticket.id)" v-else type="checkbox" role="switch" style="width:3em;height:1.5em;">
                  </div>
                </th>
  </template>