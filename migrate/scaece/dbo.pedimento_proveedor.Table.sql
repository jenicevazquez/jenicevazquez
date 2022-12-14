/****** Object:  Table [dbo].[pedimento_proveedor]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pedimento_proveedor](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pedimento_id] [int] NULL,
	[proveedor_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_pedimento_proveedor] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
